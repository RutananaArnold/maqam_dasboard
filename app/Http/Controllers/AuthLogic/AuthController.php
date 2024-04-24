<?php

namespace App\Http\Controllers\AuthLogic;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Booking;
use App\Models\MaqamEx;
use App\Models\Package;
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

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->created_at = $currentTime;
        $user->updated_at = $currentTime;


        if ($user->save()) {
            return redirect()->route('login')->with('success', 'New user registered successfully');
        } else {
            return redirect()->back()->with('error', 'failed registration');
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
        $bookings = Booking::count();
        $totalUsers = User::count();
        $totalAdverts = Advert::count();
        $totalPackages = Package::count();
        $maqamExperiences = MaqamEx::count();

        return view('dashboard',  compact('totalAdverts', 'totalUsers', 'totalPackages', 'maqamExperiences', 'bookings'));
    }

    public function showProfile()
    {
        return view('profile');
    }

    //logout logic
    public function logout(Request $request)
    {
        // Your custom logic here, if needed

        $request->session()->invalidate();

        return redirect('/'); // Redirect to the home page after logout
    }

    public function deleteUserInformation(Request $request)
    {
        $phone = $request->phone;

        // Find the user with the given phone number
        $user = User::where('phone', $phone)->first();

        if ($user) {
            // User found, delete the user
            $user->delete();
            return redirect()->back()->with('success', 'User information deleted successfully');
        } else {
            // User not found
            return redirect()->back()->with('error', 'User not found');
        }
    }
}
