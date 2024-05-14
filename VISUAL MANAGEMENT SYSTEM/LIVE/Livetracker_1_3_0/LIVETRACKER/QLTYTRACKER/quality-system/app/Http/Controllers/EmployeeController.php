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
        

         // Create a new instance of FinalAssemblyFormData
         $finalAssemblyFormData = new Employee;
         $finalAssemblyFormData->FirstName = $request->input('first_name');
         $finalAssemblyFormData->LastName = $request->input('last_name');
         $finalAssemblyFormData->login = $request->input('login');
         $finalAssemblyFormData->ClockNumber = $request->input('clock_number');
         $finalAssemblyFormData->Department = $request->input('department');
         $finalAssemblyFormData->Role = $request->input('role');

       
 
         // Save the Final Assembly Form Data
         $finalAssemblyFormData->save();
 
         // You can return a response or redirect as needed
        return response()->json(['data' => $finalAssemblyFormData]);

        // Create and save the employee
        //Employee::save($request->all());

        // Redirect back with success message
        //return redirect()->back()->with('success', 'Employee created successfully.');
    }
}


