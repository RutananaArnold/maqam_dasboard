<?php

namespace App\Http\Controllers\Bookings;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingsController extends Controller
{
    public function showAppBookings()
    {
        $bookings = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.userId')
            ->join('packages', 'packages.id', '=', 'bookings.packageId')
            ->select(
                'users.id  as userId',
                'bookings.id as bookId',
                'users.name',
                'users.phone',
                'packages.category',
                'packages.title',
                'bookings.created_at',
            )
            ->where('bookings.bookingType', '=', 'App')
            ->orderBy('bookings.created_at', 'desc')
            ->get();
        return view('bookings.view_app_bookings', ['bookings' => $bookings]);
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
            ->where('bookings.id', '=', $bookId)
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        $payments = DB::table('booking_payments')
            ->leftJoin('users', 'users.id', '=', 'booking_payments.issuedBy')
            ->select(
                'booking_payments.id',
                'booking_payments.bookingId',
                'booking_payments.amount',
                'booking_payments.payment_status',
                'booking_payments.paymentOption',
                'booking_payments.created_at',
                'users.name as issuedBy'
            )
            ->where('booking_payments.bookingId', '=', $bookId)
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
        $currentDocument = Booking::where('id', '=', $bookingId)->value('travelDocument');

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

        $document = Booking::where('id', '=', $bookingId)->update(['travelDocument' => $uniqueFileName]);

        if ($document) {
            return redirect()->back()->with('success', 'Travel document attached successfully.');
        } else {
            return redirect()->back()->with('error', 'Travel document failed to be attached.');
        }
    }

    public function updatePaymentStatus(Request $request)
    {
        $paymentId = $request->paymentId;
        $bookingId = $request->bookingId;
        $payment_status = $request->payment_status;

        $updated = DB::table('booking_payments')
            ->where('booking_payments.id', '=', $paymentId)
            ->where('booking_payments.bookingId', '=', $bookingId)
            ->update([
                "payment_status" => $payment_status,
            ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Booking payment status updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Booking payment status not updated.');
        }
    }

    public function updateClientBookingPayment(Request $request)
    {
        $request->validate([
            'bookingId' => 'required',
            "paymentOption" => 'required|string',
            'amount' => 'required|string',
            'currency' => 'required|string'
        ]);
        $rate = $request->rate;

        $bookingId = $request['bookingId'];
        $paymentOption = $request['paymentOption'];
        $bookingAmount = $request['amount'];
        $currency = $request['currency'];

        $actualAmount = 0.0;

        if ($currency == 'USD') {
            $actualAmount = $bookingAmount * $rate;
        } else if ($currency == 'UGX') {
            $actualAmount = $bookingAmount;
        }

        $payments = new BookingPayment();
        $payments->bookingId = $bookingId;
        $payments->amount = $bookingAmount;
        $payments->paymentOption = $paymentOption;
        $payments->currency = $currency;
        $payments->rate = $rate;
        $payments->actual_amount = $actualAmount;

        try {

            if ($payments->save()) {
                return redirect()->back()->with('success', 'Payment Details updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to save payment details.');
            }
        } catch (\Exception $e) {
            // Log the error and show a message
            echo json_encode($e->getMessage());
            return redirect()->back()->with('error', 'Error while saving payment.');
        }
    }


    // Regular Booking
    public function viewRegularBookings()
    {
        $bookings = DB::table('bookings')
            ->join('users', 'users.id', '=', 'bookings.userId')
            ->join('packages', 'packages.id', '=', 'bookings.packageId')
            ->select(
                'users.id  as userId',
                'bookings.id as bookId',
                'users.name',
                'users.phone',
                'packages.category',
                'packages.title',
                'bookings.created_at',
            )
            ->where('bookings.bookingType', '=', 'Regular')
            ->orderBy('bookings.created_at', 'desc')
            ->get();
        return view('bookings.regular_bookings', ['bookings' => $bookings]);
    }

    public function addRegularBookingView()
    {
        $packages = DB::table('packages')
            ->select(
                'packages.id',
                'packages.category',
                'packages.title',
            )
            ->get();

        return view('bookings.add_regular_booking', ['packages' => $packages]);
    }

    public function createRegularBooking(Request $request)
    {
        $name = $request->name;
        $phone = $request->phone;
        $gender = $request->gender;
        $dob = $request->dob;
        $email = $request->email;
        $nationality = $request->nationality;
        $residence = $request->residence;
        $packageId = $request->packageId;
        $ninOrPassport = $request->nin_or_passport;

        $currentDateTime = now()->setTimezone('Africa/Nairobi');

        // Handle the uploaded image
        $passportPhoto = $request->file('image');  // Get the uploaded file

        if ($passportPhoto) {
            // Store the image in the 'public/bookingImages' folder
            $file = uniqid() . '.' . $passportPhoto->getClientOriginalExtension();  // Generate unique filename with original extension
            $passportPhoto->move(public_path('bookingImages'), $file); // Save the file to the specified folder
        }

        try {
            $id = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email ?? "example@gmail.com",
                'phone' => $phone,
                'password' => Hash::make($phone),
                'role' => 3,
                'gender' => $gender,
                'dob' => $dob ?? '00/00/0000',
                'nationality' => $nationality,
                'residence' => $residence,
                'NIN_or_Passport' => $ninOrPassport,
                'passportPhoto' => $file ?? null,  // Store the file name if the file was uploaded
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime
            ]);

            $newBooking = new Booking();
            $newBooking->userId = $id;
            $newBooking->packageId = $packageId;
            $newBooking->bookingType = 'Regular';
            if ($newBooking->save()) {
                return redirect('/regular-bookings')->with('success', 'Regular Booking saved Successfully.');
            } else {
                return redirect()->back()->with('error', 'Regular Booking not saved.');
            }
        } catch (Exception $e) {
            // Log the error and show a message
            echo json_encode($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function generateBookingReceipt(Request $request)
    {
        $authId = $request->authId;
        $bookingId = $request->bookingId;
        $paymentId = $request->paymentId;

        // Update the issuedBy field and check if the update was successful
        $updated = DB::table('booking_payments')
            ->where('booking_payments.id', '=', $paymentId)
            ->where('booking_payments.bookingId', '=', $bookingId)
            ->update([
                "issuedBy" => $authId,
            ]);

        // Fetch a single record
        $record = DB::table('bookings')
            ->join('booking_payments', 'booking_payments.bookingId', '=', 'bookings.id')
            ->join('users as issuedByUser', 'issuedByUser.id', '=', 'booking_payments.issuedBy') // Alias for 'issuedBy' user
            ->join('users as clientUser', 'clientUser.id', '=', 'bookings.userId') // Alias for 'userId' user
            ->join('packages', 'packages.id', '=', 'bookings.packageId')
            ->select(
                'clientUser.name as client', // Refers to the user who made the booking
                'packages.category',
                'packages.title',
                'booking_payments.paymentOption',
                'booking_payments.actual_amount',
                'booking_payments.currency',
                'booking_payments.rate',
                'issuedByUser.name as issuedBy' // Refers to the user who issued the payment
            )
            ->where('booking_payments.bookingId', '=', $bookingId)
            ->where('booking_payments.id', '=', $paymentId)
            ->first();


        $amountDepositedUptodate = $this->getTotalAmountUserHasSaved($bookingId);  // Get total saved amount

        if (!$record) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Generate the PDF content
        $pdf = Pdf::loadView('bookings.booking_receipt', [
            'name' => $record->client,
            'bookingType' => $record->category,
            'package' => $record->title,
            'modeOfPayment' => $record->paymentOption,
            'amountDeposited' => $record->actual_amount,
            'currency' => $record->currency,
            'rate' => $record->rate,
            'amountDepositedUptodate' => $amountDepositedUptodate,
            'issuedBy' => $record->issuedBy,
            'currentDate' => now('Africa/Nairobi')->format('d/m/Y')
        ]);

        $fileName = Str::slug($record->client) . '-' . now('Africa/Nairobi')->format('d-m-Y') . '-maqam-e-receipt.pdf';

        return $pdf->download($fileName);
    }

    function getTotalAmountUserHasSaved($bookingId)
    {
        // Sum all 'actual_amount' for the specified sondaMpolaId
        $totalAmountSaved = DB::table('booking_payments')
            ->where('bookingId', '=', $bookingId)
            ->sum('actual_amount');  // use the sum() method

        return $totalAmountSaved;
    }
}
