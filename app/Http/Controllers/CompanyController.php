<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Jobs\SendEmail;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Illuminate\Support\Facades\File;
use App\Models\Employee;
use Yajra\DataTables\DataTables;

/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $query = Company::query();

        if ($search = $request->input('search')) {
            $query->where('companies_name', 'LIKE', '%' . $search . '%');
        }
        $companies = $query->paginate(5);
        return view('company.all_companies', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('company.create_company');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCompanyRequest $request)
    {
        $request->validated();

        $filename = Str::random(20) . '.' . $request->file('logo')->getClientOriginalExtension();

        $path =  $request->file('logo')->storeAs('public', $filename);
        $url = Storage::url($path);

        $new_company = new Company();
        $new_company->companies_name = $request->company_name;
        $new_company->email = $request->email;
        $new_company->logo = $url;
        $new_company->website = $request->website;
        $new_company->save();

        $companyname = $request->company_name;
        $email = $request->email;
       
        SendEmail::dispatch($email,$companyname);
        return redirect()->route('companies.index')->with('success', 'Company added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

  /**
 * Show the form for editing the specified resource.
 *
 * @param string $id The ID of the company to be edited
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
 */
public function edit(string $id)
{
    $company_data = Company::findOrFail($id);
    
    return view('company.edit_company', compact('company_data'));
}
/**
 * Update the specified resource in storage.
 *
 * @param UpdateCompanyRequest $request The update request containing new data
 * @param string $id The ID of the company to be updated
 * @return \Illuminate\Http\RedirectResponse
 */
public function update(UpdateCompanyRequest $request, string $id)
{
    $update_data = Company::findOrFail($id);

    $oldLogoPath = $update_data->logo;

    $request->validated();

    if ($request->hasFile('logo')) {
        $destination = 'storage/app/public/' . $oldLogoPath;
        if (file::exists($destination)) {
            file::delete($destination);
        }

        $filename = Str::random(20) . '.' . $request->file('logo')->getClientOriginalExtension();

        $path =  $request->file('logo')->storeAs('public', $filename);
        $url = Storage::url($path);
        $update_data->logo = $url;

    }

    $update_data->companies_name = $request->company_name;
    $update_data->email = $request->email;
    $update_data->website = $request->website;
    try{
        $update_data->update();
        return redirect()->route('companies.index')->with('success', 'company updated successfully');
        }catch(\Exception $e){
            return redirect()->route('companies.index')->with('success', 'company not updated email already exist');
        }
}

/**
 * Remove the specified resource from storage.
 *
 * @param string $id The ID of the company to be deleted
 * @return \Illuminate\Http\RedirectResponse
 */
public function destroy(string $id)
{
    Company::findOrFail($id)->delete();

    Employee::where('company_id', $id)->delete();

    return redirect()->route('companies.index')->with('success', 'Company deleted successfully');
}

/**
 * Show the list of employees for a specific company.
 *
 * @param Request $request The request object
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
 */
public function showEmployeeList(Request $request)
{
    if ($request->ajax()) {
        $employees = Employee::where('company_id', $request->id)->get();
        return Datatables::of($employees)
            ->addIndexColumn()
            ->addColumn('company', function ($employees) {
                return $employees->company->companies_name;
            })
            ->rawColumns(['action', 'company'])
            ->make(true);
    }

    $companyId = $request->id;
    $employees = Employee::where('company_id', $request->id)->get();
    return view('company.employeeListOfSelectedCompany', compact('companyId','employees'));
}

/**
 * Show the list of deleted companies.
 *
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
 */
public function deleted_companies()
{
    $deletedRecords = Company::onlyTrashed()->get();
    return view('company.removed_companies', compact(['deletedRecords']));
}

/**
 * Restore a deleted company.
 *
 * @param Request $request The request object containing the company ID
 * @return \Illuminate\Http\RedirectResponse
 */
public function restore(Request $request)
{
    $record = Company::withTrashed()->find($request->company);
    $record->restore();

    $record = Employee::onlyTrashed()->where('company_id', $request->company);
    $record->restore();

    return redirect()->route('companies.index')->with('success', 'Company details restored successfully');
}

}
