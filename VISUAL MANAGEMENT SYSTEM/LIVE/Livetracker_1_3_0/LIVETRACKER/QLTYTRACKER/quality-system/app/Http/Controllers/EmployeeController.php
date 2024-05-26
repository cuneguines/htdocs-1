<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // Show the form for creating a new employee
    public function create()
    {
        return view('employees');
    }

    // Store a newly created employee in the database
    public function store(Request $request)
    {
        $employee = new Employee;
        $employee->FirstName = $request->input('first_name');
        $employee->LastName = $request->input('last_name');
        $employee->login = $request->input('login');
        $employee->ClockNumber = $request->input('clock_number');
        $employee->Department = $request->input('department');
        $employee->Role = $request->input('role');

        $employee->save();

        return response()->json(['data' => $employee]);
    }

    // Fetch all employees
    public function getemployee()
    {
        $employees = Employee::all();
        return response()->json(['data' => $employees]);
    }

    // Update an employee
    public function updateEmployee(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->FirstName = $request->input('first_name');
        $employee->LastName = $request->input('last_name');
        $employee->Login = $request->input('login');
        $employee->ClockNumber = $request->input('clock_number');
        $employee->Department = $request->input('department');
        $employee->Role = $request->input('role');

        $employee->save();

        return response()->json(['data' => $employee]);
    }

    // Delete an employee (change status to deleted)
    public function deleteEmployee($id)
    {
        //$employee = Employee::findOrFail($id);
       // $employee->Status = 'deleted'; // Assuming you have a status field
       // $employee->save();

       // return response()->json(['success' => 'Employee status changed to deleted successfully']);
  
    }
    public function getemployees(Request $request, $id)
    {
        $employees = Employee::findOrFail($id);
        return response()->json(['data' => $employees]);
    }
}
