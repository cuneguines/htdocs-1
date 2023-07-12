<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
   public function index()
{
    try {
        $ordr = DB::connection('KENTSTAINLESS')->table('ordr')->get();
        var_dump($ordr); // Inspect the variable
        return view('index', compact('ordr'));
    } catch (\Exception $e) {
        // Log or handle the exception as needed
        return "An error occurred: " . $e->getMessage();
    }
}
}