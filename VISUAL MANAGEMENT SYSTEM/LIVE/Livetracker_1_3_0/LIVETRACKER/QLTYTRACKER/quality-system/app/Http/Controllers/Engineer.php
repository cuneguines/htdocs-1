<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class Engineer extends Controller
{
    public function ShowEngineerForm()
    {
        $userId = Session::get('user');
        return view('engineer_task');
    }

}
