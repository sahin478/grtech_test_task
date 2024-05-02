<?php

namespace App\Http\Controllers;

use App\Notifications\NewEmployeeNotification;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Company;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    
    public function index(Request $request)
{
    
    $companies = Company::orderBy('created_at', 'desc')->get();
    // Start building the query for employees
    $query = Employee::with('company')->orderBy('created_at', 'desc');

    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    if ($request->filled('first_name')) {
        $query->where('first_name', 'like', '%' . $request->first_name . '%');
    }

    if ($request->filled('last_name')) {
        $query->where('last_name', 'like', '%' . $request->last_name . '%');
    }

    if ($request->filled('company_id')) {
        $query->where('company_id', $request->company_id);
    }


    // Fetch paginated results after applying filters
    $employees = $query->paginate(20);

    // Pass data to Inertia view
    return Inertia::render('Employee/Employee', [
        'employees' => $employees->toArray(),
        'companies' => $companies,
        'filters' => $request->all(), // Send back filters to pre-fill form
    ]);
}

    
    public function store(EmployeeRequest $request)
    {
        $validatedData = $request->validated();

        $employee = Employee::create($validatedData);
        $employee->company->notify(new NewEmployeeNotification($employee));

        return response()->json(['message' => 'Employee created successfully','data'=>(new EmployeeResource($employee))]);

    }

   
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

   
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $validatedData = $request->validated();

        $employee->update($validatedData);

        return response()->json(['message' => 'Employee updated successfully','data'=>(new EmployeeResource($employee))]);
    }

    
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
