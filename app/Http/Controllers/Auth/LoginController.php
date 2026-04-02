<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use DB;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route(
                Auth::user()->user_type == 1 ? 'admin-dashboard' : 'employee.dashboard'
            );
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required'    => 'The email field is required.',
            'password.required' => 'The password field is required.',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();
            $user = Auth::user();
            // dd($user);
            // Redirect based on user type
            return match ($user->role_id) {
                1 => redirect()->route('admin-dashboard'),       // Admin
                2 => redirect()->route('employee.dashboard'),   // Employee
                default => abort(403),
            };
        } 

        return redirect()->route('login')
            ->withErrors(['email' => 'Invalid login credentials']);
    }

    public function logout(Request $request) 
    {
        // Log out the admin using the admin guard
         Auth::guard('web')->logout(); 
        $request->session()->forget('adminlogin');
        $request->session()->regenerateToken();        
        // Redirect to the login page
        return redirect('/login');
    }
}
