<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Rules\UniqueEmailInCompany;
use Illuminate\Support\Facades\Session;
/**
 * EmployeeController
 */
class EmployeeController extends Controller
{
   /**
 * Display a listing of the resource.
 *
 * @param Request $request The request object
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
 */
public function index(Request $request)
{
    if ($request->ajax()) {
        $employees = Employee::with('company')->get();
        return Datatables::of($employees)
            ->addIndexColumn()
            ->addColumn('company', function ($employees) {
                return $employees->company->companies_name;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    $employees = Employee::with('company')->get();
    return view('employee.all_employees',compact('employees'));
}

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
 */
public function create()
{
    $companies = Company::all();
    return view('employee.create_employee', compact('companies'));
}

/**
 * Store a newly created resource in storage.
 *
 * @param StoreEmployeeRequest $request The store request containing new data
 * @return \Illuminate\Http\RedirectResponse
 */
public function store(StoreEmployeeRequest $request)
{
    $request->validated();

    $new_employee = new Employee();
    $new_employee->first_name = $request->first_name;
    $new_employee->last_name = $request->last_name;
    $new_employee->company_id = $request->company_name;
    $new_employee->email = $request->email;
    $new_employee->phone = $request->phone;
    $new_employee->save();

    return redirect()->route('employees.index')->with('success', 'Employee added successfully');
}

/**
 * Show the specified resource.
 *
 * @param string $id The ID of the employee to be shown
 * @return void
 */
public function show(string $id)
{
    // No implementation needed for this method
}

/**
 * Show the form for editing the specified resource.
 *
 * @param string $id The ID of the employee to be edited
 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
 */
public function edit(Request $request,string $id)
{
    Session::put('url',url()->previous());
    $companies = Company::all();
    $employee_data = Employee::findOrFail($id);
    return view('employee.edit_employee', compact(['employee_data', 'companies']));
}

/**
 * Update the specified resource in storage.
 *
 * @param StoreEmployeeRequest $request The update request containing new data
 * @param string $id The ID of the employee to be updated
 * @return \Illuminate\Http\RedirectResponse
 */
public function update(UpdateEmployeeRequest $request, string $id)
{
    $update_data = Employee::findOrFail($id);
    $request->validated();

    $update_data->first_name = $request->first_name;
    $update_data->last_name = $request->last_name;
    $update_data->company_id = $request->company_name;
    $update_data->email = $request->email;
    $update_data->phone = $request->phone;
    try{
        $update_data->update();
        return redirect(Session::get('url'))->with('success', 'Employee updated successfully');
        }catch(\Exception $e){
            return redirect(Session::get('url'))->with('success', 'Employee not updated email already exist');
        }
}

/**
 * Remove the specified resource from storage.
 *
 * @param string $id The ID of the employee to be deleted
 * @return \Illuminate\Http\RedirectResponse
 */
public function destroy(string $id)
{
    Employee::findOrFail($id)->delete();
    return redirect(Session::get('url'))->with('success','employee deleted successfully');
}

}
