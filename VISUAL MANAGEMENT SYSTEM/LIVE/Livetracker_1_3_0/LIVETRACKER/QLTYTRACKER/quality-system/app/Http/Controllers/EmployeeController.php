<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    public function getEmployee()
{
    // Retrieve all employees where Status is not 'deleted', ordered by FirstName
    $employees = Employee::where('Status', '!=', 'deleted')  // Status is not 'deleted'
    ->orWhereNull('Status')  // OR Status is NULL
    ->orderBy('FirstName', 'asc')  // Sort by 'FirstName' or any other column
    ->get();

return response()->json(['data' => $employees]);
}

    // Update an employee
    public function updateEmployee(Request $request, $id)
    {
       
try {
    // Prepare the update statement
    $updateQuery = "
        UPDATE [QUALITY_PACK].[dbo].[User]
        SET
            FirstName = :first_name,
            LastName = :last_name,
            Login = :login,
            ClockNumber = :clock_number,
            Department = :department,
            Role = :role
        WHERE
            id = :id
    ";

    // Execute the update query
    DB::update($updateQuery, [
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'login' => $request->input('login'),
        'clock_number' => $request->input('clock_number'),
        'department' => $request->input('department'),
        'role' => $request->input('role'),
        'id' => $id,
    ]);

    // Fetch the updated employee record
    $employee = DB::select("SELECT * FROM [QUALITY_PACK].[dbo].[User] WHERE id = :id", ['id' => $id]);

    // Return success response with updated employee
    return response()->json(['data' => $employee], 200);
} catch (\Exception $e) {
    // Log the exception message
    Log::error('Update failed: ' . $e->getMessage());

    // Return error response
    return response()->json(['error' => 'Update failed. Please try again later.'], 500);
}

    }

    // Delete an employee (change status to deleted)
    public function deleteEmployee($id)
{
    try {
        // Prepare the update statement for marking employee as deleted
        $deleteQuery = "
            UPDAT
            SET
                Status = 'deleted'  -- Assuming you have a 'Status' field
            WHERE
                id = :id
        ";

        // Execute the update query
        DB::update($deleteQuery, ['id' => $id]);

        // Optionally, fetch the updated employee record
        $employee = DB::select("SELECT * FROM [QUALITY_PACK].[dbo].[User] WHERE id = :id", ['id' => $id]);

        // Return success response
        return response()->json(['success' => 'Employee status changed to deleted successfully', 'data' => $employee], 200);
    } catch (\Exception $e) {
        // Log the exception message
        Log::error('Delete operation failed: ' . $e->getMessage());

        // Return error response
        return response()->json(['error' => 'Delete operation failed. Please try again later.'], 500);
    }
}
    public function getemployees(Request $request, $id)
    {
        $employees = Employee::findOrFail($id);
        return response()->json(['data' => $employees]);
    }
}
