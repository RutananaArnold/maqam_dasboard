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

    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            "email" => 'required|string',
            'phone' => 'required|string',
            'gender' => 'required|string',
            'dob' => 'required|date_format:d/m/Y',
            'nationality' => 'required|string',
            'residence' => 'required|string',
            'nin_or_passport' => 'required|string',
        ]);

        // Handle image upload
        $imageName = null; // Initialize image name variable
        if ($request->hasFile('image')) {
            // Get the file from the request
            $image = $request->file('image');
            // Generate a unique name for the image using the current timestamp
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Move the image to the folder
            $image->move(public_path('bookingImages'), $imageName);
        }

        $currentTime = now()->setTimezone('Africa/Nairobi');

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->gender = $request['gender'];
        $user->dob = $request['dob'];
        $user->nationality = $request['nationality'];
        $user->residence = $request['residence'];
        $user->NIN_or_Passport = $request['nin_or_passport'];
        $user->passportPhoto = $imageName; // Store the file name if the file was uploaded
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->created_at = $currentTime;
        $user->updated_at = $currentTime;


        if ($user->save()) {
            return redirect()->back()->with('success', 'New user registered successfully');
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
            $user = Auth::user();
            $userRoleId = (int) $user->role;
            // Check if the user's roleId is a specific value
            if ($userRoleId === 1 || $userRoleId === 2) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            } else {
                return redirect()->back()->with('error', 'The provided credentials belong to Maqam Travels client');
            }
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
        $user = User::where('phone', '=', $phone)->first();

        if ($user) {
            // User found, delete the user
            $user->delete();
            return redirect()->back()->with('success', 'User information deleted successfully');
        } else {
            // User not found
            return redirect()->back()->with('error', 'User not found');
        }
    }

    public function viewSystemUsers()
    {
        $users = DB::table('users')
            ->join('user_roles', 'user_roles.id', '=', 'users.role')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.phone',
                'users.gender',
                'users.dob',
                'users.nationality',
                'users.residence',
                'users.NIN_or_Passport',
                'user_roles.Role as system_role',
            )
            ->orderBy('users.created_at', 'desc')
            ->get();
        return view('auth.system_users', ['users' => $users]);
    }
}
