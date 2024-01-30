<?php

namespace App\Http\Controllers\AuthLogic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function registration(Request $request)
    {
        $response =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($response) {
            return redirect()->route('login');
        }
    }


    //login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();


            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showDashboard()
    {
        // $totalAgents = Policy::count();
        $totalUsers = User::count();
        $totalAgents = 0;

        return view('dashboard',  compact('totalAgents', 'totalUsers'));
    }


    //logout logic
    protected function logout(Request $request)
    {
        // Your custom logic here, if needed

        $request->session()->invalidate();

        return redirect('/'); // Redirect to the home page after logout
    }
}
