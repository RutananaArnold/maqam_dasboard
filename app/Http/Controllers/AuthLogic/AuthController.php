<?php

namespace App\Http\Controllers\AuthLogic;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        $roles = DB::table('user_roles')->get();
        return view('auth.register', ['roles' => $roles]);
    }

    protected function registration(Request $request)
    {
        $currentTime = now();

        $user =  DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'created_at' => $currentTime,
            'updated_at' => $currentTime
        ]);


        if ($user) {
            return redirect()->back()->with('success', 'New user registered successfully');
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
        $totalAdverts = Advert::count();

        return view('dashboard',  compact('totalAdverts', 'totalUsers'));
    }


    //logout logic
    protected function logout(Request $request)
    {
        // Your custom logic here, if needed

        $request->session()->invalidate();

        return redirect('/'); // Redirect to the home page after logout
    }
}
