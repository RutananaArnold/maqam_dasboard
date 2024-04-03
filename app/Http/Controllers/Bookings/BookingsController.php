<?php

namespace App\Http\Controllers\Bookings;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class BookingsController extends Controller
{
    public function showAllBookings()
    {
        $bookings = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.userId')
            ->join('packages', 'packages.id', '=', 'bookings.packageId')
            ->select(
                'users.id  as userId',
                'bookings.id as bookId',
                'users.name',
                'users.phone',
                'users.gender',
                'users.nationality',
                'users.residence',
                'packages.category',
            )
            ->orderBy('bookings.created_at', 'desc')
            ->get();
        return view('bookings.view_all_bookings', ['bookings' => $bookings]);
    }

    public function viewBooking(Request $request)
    {
        $bookId = $request->bookingId;

        $userBooking = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.userId')
            ->join('packages', 'packages.id', '=', 'bookings.packageId')
            ->select(
                'bookings.userId  as idOfUser',
                'users.name',
                'users.email',
                'users.phone',
                'users.nationality',
                'users.residence',
                'users.NIN_or_Passport',
                'users.passportPhoto',
                'bookings.id as bookingId',
                'bookings.travelDocument'
            )
            ->where('bookings.id', $bookId)
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        $payments = DB::table('booking_payments')
            ->join('bookings', 'bookings.id', '=', 'booking_payments.bookingId')
            ->select(
                'booking_payments.amount',
                'bookings.paymentOption',
                'booking_payments.created_at'
            )
            ->where('booking_payments.bookingId', $bookId)
            ->orderBy('booking_payments.created_at', 'desc')
            ->get();

        return view('bookings.attach_travel_doc', ['userBooking' => $userBooking, 'payments' => $payments, 'bookingId' => $bookId]);
    }

    public function downloadPassport(Request $request)
    {
        $userId = $request->userId;

        $user = User::find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User don\'t exist.');
        }
        // Generate the URL for the image
        $filepath = public_path('bookingImages/') . $user->passportPhoto;

        // Get the original file extension
        $extension = pathinfo($filepath, PATHINFO_EXTENSION);
        // Generate the new file name
        $new_file_name = $user->name . '.' . $extension;

        return response()->download($filepath, $new_file_name);
    }

    public function attachTravelDocument(Request $request)
    {
        $bookingId = $request->bookingId;
        $pdf_file = $request->pdf_file;

        if (!$pdf_file->isValid()) {
            return redirect()->back()->with('error', 'Invalid PDF file.');
        }

        // Get the current travel document file name
        $currentDocument = Booking::where('id', $bookingId)->value('travelDocument');

        // Delete the current travel document file if it exists
        if ($currentDocument) {
            $filePath = public_path('travelDocuments/' . $currentDocument);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $uniqueFileName = uniqid() . $pdf_file->getClientOriginalName();

        $filePath = public_path() . '/travelDocuments/';
        $pdf_file->move($filePath, $uniqueFileName);

        $document = Booking::where('id', $bookingId)->update(['travelDocument' => $uniqueFileName]);

        if ($document) {
            return redirect()->back()->with('success', 'Travel document attached successfully.');
        } else {
            return redirect()->back()->with('error', 'Travel document failed to be attached.');
        }
    }
}
