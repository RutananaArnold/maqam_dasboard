<?php

namespace App\Http\Controllers\Bookings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingsController extends Controller
{
    public function showAllBookings()
    {
        $bookings = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.userId')
            ->join('packages', 'packages.id', '=', 'bookings.packageId')
            ->orderBy('bookings.created_at', 'desc')
            ->get();
        return view('bookings.view_all_bookings', ['bookings' => $bookings]);
    }
}
