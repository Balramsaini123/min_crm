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
        // Retrieve paginated companies data
        $companies = $query->paginate(5);
        // Return view with companies data
        return view('company.all_companies', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Return view for creating a new company
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
        // Validate the incoming request
        $request->validated();

        // Generate a unique filename for the logo
        $filename = Str::random(20) . '.' . $request->file('logo')->getClientOriginalExtension();

        // Store the logo file in the storage
        $path =  $request->file('logo')->storeAs('public', $filename);
        $url = Storage::url($path);

        // Create a new Company instance and save it to the database
        $new_company = new Company();
        $new_company->companies_name = $request->company_name;
        $new_company->email = $request->email;
        $new_company->logo = $url;
        $new_company->website = $request->website;
        $new_company->save();

        // Send welcome email to the new company
        $companyname = $request->company_name;
        $email = $request->email;
       
        SendEmail::dispatch($email,$companyname);
        // Redirect with success message
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
    // Retrieve the company data by its ID
    $company_data = Company::findOrFail($id);
    
    // Return the view for editing the company data, passing the retrieved data
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
    // Retrieve the company data by its ID
    $update_data = Company::findOrFail($id);

    // Get the path of the old logo
    $oldLogoPath = $update_data->logo;

    // Validate the incoming request
    $request->validated();

    // Check if a new logo file is uploaded
    if ($request->hasFile('logo')) {
        // Delete the old logo file
        $destination = 'storage/app/public/' . $oldLogoPath;
        if (file::exists($destination)) {
            file::delete($destination);
        }

        // Generate a new unique filename for the logo
        $filename = Str::random(20) . '.' . $request->file('logo')->getClientOriginalExtension();

        // Store the new logo file
        $path =  $request->file('logo')->storeAs('public', $filename);
        $url = Storage::url($path);
    } else {
        // If no new logo is uploaded, keep the existing logo
        $url = $oldLogoPath;
    }

    // Update the company data with the new values
    $update_data->companies_name = $request->company_name;
    $update_data->email = $request->email;
    $update_data->logo = $url;
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
    // Delete the company by its ID
    Company::findOrFail($id)->delete();

    // Delete the associated employees
    Employee::where('company_id', $id)->delete();

    // Redirect with success message
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
    // If the request is AJAX, return JSON data for DataTables
    if ($request->ajax()) {
        $employees = Employee::where('company_id', $request->id)->get();
        return Datatables::of($employees)
            ->addIndexColumn()
            ->addColumn('company', function ($employees) {
                return $employees->company->companies_name;
            })
            ->addColumn('action', function ($row) {
                return '<button onclick="openform(' . htmlspecialchars(json_encode($row)) . ')">Edit</button> <button onclick="deletefun(' . $row->id . ')">Delete</button>';
            })
            ->rawColumns(['action', 'company'])
            ->make(true);
    }

    // If not AJAX, pass the employees data to the view
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
    // Retrieve all deleted companies
    $deletedRecords = Company::onlyTrashed()->get();
    // Return the view with deleted companies data
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
    // Find the deleted company by its ID and restore it
    $record = Company::withTrashed()->find($request->company);
    $record->restore();

    // Restore the associated employees
    $record = Employee::onlyTrashed()->where('company_id', $request->company);
    $record->restore();

    // Redirect with success message
    return redirect()->route('companies.index')->with('success', 'Company details restored successfully');
}

}
