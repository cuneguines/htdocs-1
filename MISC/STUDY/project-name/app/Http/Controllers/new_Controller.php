<?php

namespace App\Http\Controllers;
use App\Http\Controllers\new_Controller;
use Illuminate\Http\Request;

class new_Controller extends Controller
{
    public function storeData(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:your_table_name,email',
    ]);

    // Create a new record in the database
    DB::table('new_table')->insert([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
    ]);

    // Redirect or return a response
    return redirect()->route('form')->with('success', 'Data has been saved successfully.');
}
}
