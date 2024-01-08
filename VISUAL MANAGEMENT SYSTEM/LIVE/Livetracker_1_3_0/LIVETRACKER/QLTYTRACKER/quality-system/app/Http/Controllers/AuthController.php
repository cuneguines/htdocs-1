<?php



namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function processorders()
    {
        return view('processorders');
    }
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
       
            $credentials = $request->only('Login', 'Password');
        
            // Retrieve the user based on the login field
            $user = User::where('Login', $credentials['Login'])->first();
        
            if ($user && $user->Password == $credentials['Password']) {
                // Authentication successful
                Auth::login($user);
                Session::put('user_id', $user->Login);
            
                return redirect()->intended('processorders');
            }
            
        // Authentication failed
    // Authentication failed
    Session::flash('error', 'Invalid login credentials');
    Session::flashInput($request->except('Password'));

    return redirect()->route('login');
        }
    


    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
