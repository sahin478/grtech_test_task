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
    
    public function index()
    {
       
        $companies = Company::orderBy('created_at', 'desc')->get();
        $employees = Employee::with('company')->orderBy('created_at', 'desc')->paginate(4);
       
        return Inertia::render('Employee/Employee', ['employees'=>($employees)->toArray() ,'companies' => $companies]);
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
