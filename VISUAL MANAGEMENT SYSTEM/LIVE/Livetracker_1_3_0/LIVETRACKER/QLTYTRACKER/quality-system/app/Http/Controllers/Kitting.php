<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class Kitting extends Controller
{
    public function ShowKittingForm()
    {
        $userId = Session::get('user');
        return view('kitting_task');
    }

}
