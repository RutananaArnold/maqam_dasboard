<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MobileAppController extends Controller
{
    public function createBooking(Request $request)
    {
        $userId = $request->userId;
        $name = $request->name;
        $phone = $request->phone;
        $gender = $request->gender;
        $dob = $request->dob;
        $email = $request->email;
        $nationality = $request->nationality;
        $residence = $request->residence;
        // $passportPhoto = $request->passportPhoto;
        $bookingCategory = $request->bookingCategory;

        if (!empty($userId)) {
            // identify user
            $user = DB::table('users')->select('id', 'name', 'email', 'phone', 'role')->find($userId);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 400);
            }

            $existingUserId = $user->id;

            // starting saving booking of the user
            $imageName = time() . '.' . $request->passportPhoto->extension();
            $request->passportPhoto->move(public_path('bookingImages'), $imageName);
            // create a new booking
            $newBooking = new Booking();
            $newBooking->userId = $existingUserId;
            $newBooking->gender = $gender;
            $newBooking->dob = $dob;
            $newBooking->nationality = $nationality;
            $newBooking->residence = $residence;
            $newBooking->passportPhoto = $imageName;
            $newBooking->bookingCategory = $bookingCategory;
            if ($newBooking->save()) {
                return response()->json([
                    'message' => 'Booking saved successfully',
                    'user' => $user,
                    'booking_id' => $newBooking->id,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Booking failed',
                ], 400);
            }
        } else {
            // if userId is empty, create an account for the user with their number as their password
            $currentDateTime = now();

            $id = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email ?? "example@gmail.com",
                'phone' => $phone,
                'password' => Hash::make($phone),
                'role' => 3,
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime
            ]);

            $user = DB::table('users')->select('id', 'name', 'email', 'phone', 'role')->find($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 400);
            }

            $newUserId = $user->id;
            $imageName = time() . '.' . $request->passportPhoto->extension();
            $request->passportPhoto->move(public_path('bookingImages'), $imageName);
            // create a new booking
            $newBooking = new Booking();
            $newBooking->userId = $newUserId;
            $newBooking->gender = $gender;
            $newBooking->dob = $dob;
            $newBooking->nationality = $nationality;
            $newBooking->residence = $residence;
            $newBooking->passportPhoto = $imageName;
            $newBooking->bookingCategory = $bookingCategory;
            if ($newBooking->save()) {
                return response()->json([
                    'message' => 'Booking saved successfully',
                    'user' => $user,
                    'booking_id' => $newBooking->id,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Booking failed',
                ], 400);
            }
        }
    }


    public function getUserBookings(Request $request)
    {
        $request->validate([
            'userId' => 'required',
        ]);

        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', 10);

        $bookings = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.userId')
            ->join('user_roles', 'user_roles.id', '=', 'users.role')
            ->select(
                'users.id as userId',
                'bookings.id as bookingId',
                'users.name',
                'users.phone',
                'users.email',
                'user_roles.Role',
                'bookings.gender',
                'bookings.dob',
                'bookings.nationality',
                'bookings.residence',
                'bookings.bookingCategory',
                'bookings.paymentOption',
                'bookings.amount',
                'bookings.passportPhoto',
            )
            ->where('bookings.userId', $request['userId'])
            ->orderBy('bookings.created_at', 'desc');

        $paginator = $bookings->paginate($perPage, ['*'], 'page', $page);

        if ($paginator->isNotEmpty()) {
            $userBookings = $paginator->items();

            // Generate URL for passportPhoto images
            foreach ($userBookings as &$booking) {
                $booking->passportPhoto = url('bookingImages/' . $booking->passportPhoto);
            }

            return response()->json([
                'status' => true,
                'total' => $paginator->total(),
                'current_page' => $paginator->currentPage(),
                'bookings' => $userBookings,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No bookings found',
            ]);
        }
    }

    public function updateBookingPaymentOption(Request $request)
    {
        $request->validate([
            'bookingId' => 'required',
            "paymentOption" => 'required|string',
            'amount' => 'required|string'
        ]);
        $bookingId = $request['bookingId'];
        $paymentOption = $request['paymentOption'];
        $bookingAmount = $request['amount'];

        $affectedBooking = Booking::where("id", $bookingId)->update(["paymentOption" => $paymentOption, "amount" => $bookingAmount]);

        if ($affectedBooking) {
            return response()->json([
                'status' => true,
                'message' => "Payment Option updated"
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Payment Option failed to get updated"
            ], 400);
        }
    }

    public function getPackages(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', 10);

        $packages = Package::with('services')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($packages->isNotEmpty()) {
            // Format package image URLs
            $packages->transform(function ($package) {
                $package->packageImage = url('packageImages/' . $package->packageImage);
                // Format service image URLs
                $package->services->transform(function ($service) {
                    $service->image = url('packageImages/' . $service->image);
                    return $service;
                });
                return $package;
            });

            return response()->json([
                'status' => true,
                'total' => $packages->count(),
                'packages' => $packages,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No Packages found',
            ]);
        }
    }



    // public function getPackages(Request $request)
    // {
    //     $page = $request->query('page', 1);
    //     $perPage = $request->query('perPage', 10);

    //     $packages = DB::table('packages')
    //         ->join('services', 'services.packageId', '=', 'packages.id')
    //         ->select(
    //             'packages.id',
    //             'packages.category',
    //             'packages.type',
    //             'packages.standardPrice',
    //             'packages.economyPrice',
    //             'packages.title',
    //             'packages.dateRange',
    //             'packages.packageImage',
    //             'packages.endDateTime',
    //             'services.name',
    //             'services.description',
    //             'services.image',
    //         )
    //         ->orderBy('packages.created_at', 'desc');

    //     $paginator = $packages->paginate($perPage, ['*'], 'page', $page);

    //     if ($paginator->isNotEmpty()) {
    //         $availablePackages = $paginator->items();

    //         // Generate URL for package thumbnail images
    //         foreach ($availablePackages as &$package) {
    //             $package->packageImage = url('packageImages/' . $package->packageImage);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'total' => $paginator->total(),
    //             'current_page' => $paginator->currentPage(),
    //             'packages' => $availablePackages,
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'No Packages found',
    //         ]);
    //     }
    // }
}
