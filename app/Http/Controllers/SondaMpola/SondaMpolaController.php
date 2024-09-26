<?php

namespace App\Http\Controllers\SondaMpola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class SondaMpolaController extends Controller
{
    public function view()
    {
        $sondaMpolas = DB::table('sonda_mpolas')
            ->leftJoin(
                DB::raw('(SELECT sondaMpolaId, SUM(actual_amount) as total_amount_saved, MAX(target_amount_status) as target_amount_status FROM sonda_mpola_payments GROUP BY sondaMpolaId) as payments'),
                'payments.sondaMpolaId',
                '=',
                'sonda_mpolas.id'
            )
            ->select(
                'sonda_mpolas.*',
                'payments.total_amount_saved', // Total amount saved from payments
                'payments.target_amount_status' // Fetch target_amount_status from payments
            )
            ->orderBy('sonda_mpolas.created_at', 'desc')
            ->get();

        return view('sonda_mpola.view_sonda_mpola_collections', compact('sondaMpolas'));
    }

    public function saveSondaMpolaRecord(Request $request)
    {
        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                // Get the file from the request
                $image = $request->file('image');

                // Generate a unique name for the image using the current timestamp
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                // Move the image to the 'public/sondaMpola' folder
                $image->move(public_path('sondaMpola'), $imageName);
            }

            // Reference generation logic
            $referencePrefix = 'SM/';  // Constant prefix
            $referenceMiddle = '';

            // Determine middle part based on savingFor and the saving target selected
            if ($request->input('savingFor') == 'Umrah') {
                switch ($request->input('umrahSavingTarget')) {
                    case 'Ramadhan_13200000':
                        $referenceMiddle = 'UR';
                        break;
                    case 'December_10300000':
                        $referenceMiddle = 'UD';
                        break;
                    case 'otherMonths_8400000':
                        $referenceMiddle = 'UO';
                        break;
                    default:
                        $referenceMiddle = 'UO'; // Default to 'UO' if no valid option selected
                        break;
                }
            } elseif ($request->input('savingFor') == 'Hajj') {
                switch ($request->input('hajjSavingTarget')) {
                    case 'Class_A_31800000':
                        $referenceMiddle = 'HA';
                        break;
                    case 'Class_B_21500000':
                        $referenceMiddle = 'HB';
                        break;
                    default:
                        $referenceMiddle = 'HA'; // Default to 'HA' if no valid option selected
                        break;
                }
            }

            // Get the total count of existing records to generate a unique number
            $totalRecords = DB::table('sonda_mpolas')->count();
            $referenceNumber = $totalRecords + 1;  // Increment the total count

            // Full reference
            $reference = $referencePrefix . $referenceMiddle . '/' . $referenceNumber;

            // Insert the data into the sonda_mpolas table
            DB::table('sonda_mpolas')->insert([
                'name' => $request->input('name'),
                'identificationType' => $request->input('identificationType'),
                'nin_or_passport' => $request->input('nin_or_passport'),
                'dateOfExpiry' => $request->input('dateOfExpiry'),
                'phone' => $request->input('phone'),
                'otherPhone' => $request->input('otherPhone'),
                'email' => $request->input('email'),
                'savingFor' => $request->input('savingFor'),
                'umrahSavingTarget' => $request->input('umrahSavingTarget'),
                'hajjSavingTarget' => $request->input('hajjSavingTarget'),
                'targetAmount' => $request->input('targetAmount'),
                'gender' => $request->input('gender'),
                'occupation' => $request->input('occupation'),
                'position' => $request->input('position'),
                'dob' => $request->input('dob'),
                'placeOfBirth' => $request->input('placeOfBirth'),
                'fatherName' => $request->input('fatherName'),
                'motherName' => $request->input('motherName'),
                'maritalStatus' => $request->input('maritalStatus'),
                'country' => $request->input('country'),
                'nationality' => $request->input('nationality'),
                'residence' => $request->input('residence'),
                'district' => $request->input('district'),
                'county' => $request->input('county'),
                'subcounty' => $request->input('subcounty'),
                'parish' => $request->input('parish'),
                'village' => $request->input('village'),
                'nextOfKin' => $request->input('nextOfKin'),
                'relationship' => $request->input('relationship'),
                'nextOfKinAddress' => $request->input('nextOfKinAddress'),
                'mobileNo' => $request->input('mobileNo'),
                'image' => $imageName,  // Store the image path in the database
                'reference' => $reference,  // Store the generated reference
                'process_status' => 'pending',  // Default status, modify if necessary
                'created_at' => now()->setTimezone('Africa/Nairobi'),
                'updated_at' => now()->setTimezone('Africa/Nairobi'),
                'created_by' => $request->authId,
            ]);

            // Redirect with a success message
            return redirect()->back()->with('success', 'Sonda Mpola record saved successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error saving Sonda Mpola record: ' . $e->getMessage());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to save Sonda Mpola record. Please try again.');
        }
    }

    public function viewSondaMpolaRecord(Request $request)
    {
        $sondaMpolaId = $request->sondaMpolaId;

        $sondaMpolaRecord = DB::table('sonda_mpolas')
            ->leftJoin('users', 'users.id', '=', 'sonda_mpolas.created_by')
            ->select(
                'sonda_mpolas.*',
                'users.name as account_created_by_name'
            )
            ->where('sonda_mpolas.id', '=', $sondaMpolaId)
            ->orderBy('sonda_mpolas.created_at', 'desc')
            ->first();

        $amountDepositedSoFar = $this->getTotalAmountUserHasSaved($sondaMpolaId);  // Get total saved amount

        $userPendingBalance = $this->getLatestBalance($sondaMpolaId);

        $payments = DB::table('sonda_mpola_payments')
            ->leftJoin('users', 'users.id', '=', 'sonda_mpola_payments.issuedBy')
            ->join('sonda_mpolas', 'sonda_mpolas.id', '=', 'sonda_mpola_payments.sondaMpolaId')
            ->select(
                'sonda_mpola_payments.id',
                'sonda_mpola_payments.amount',
                'sonda_mpola_payments.payment_option',
                'sonda_mpola_payments.created_at',
                'sonda_mpolas.umrahSavingTarget',
                'sonda_mpolas.hajjSavingTarget',
                'sonda_mpola_payments.balance',
                'users.name as issued_by_name'
            )
            ->where('sonda_mpola_payments.sondaMpolaId', '=', $sondaMpolaId)
            ->orderBy('sonda_mpola_payments.created_at', 'desc')
            ->get();

        return view('sonda_mpola.view_sonda_mpola_record', ['sondaMpolaRecord' => $sondaMpolaRecord, 'amountDepositedSoFar' => $amountDepositedSoFar, 'userPendingBalance' => $userPendingBalance, 'payments' => $payments, 'sondaMpolaId' => $sondaMpolaId]);
    }

    function getLatestBalance($sondaMpolaId)
    {
        // Retrieve the balance of the latest updated record based on updated_at
        $record = DB::table('sonda_mpola_payments')
            ->select('sonda_mpola_payments.balance')  // Select the balance
            ->where('sondaMpolaId', $sondaMpolaId)    // Filter by sondaMpolaId
            ->orderBy('updated_at', 'desc')           // Prioritize updated_at to get the most recent
            ->first();                                // Get the first (latest) record

        // Return the latest balance, or null if no record exists
        return $record ? $record->balance : null;
    }

    public function createSondaMpolaPaymentRecord(Request $request)
    {
        $authId = $request->authId;
        $sondaMpolaId = $request->sondaMpolaId;
        $amount = $request->amount;
        $paymentOption = $request->paymentOption;

        $userTargetAmount = DB::table('sonda_mpolas')->select('targetAmount')->where('id', '=', $sondaMpolaId)->first();

        $actualAmount = 0.0;

        $balance = 0.0;

        $actualAmount = $amount;


        // to calculate balance
        $totalSaved = $this->getTotalAmountUserHasSaved($sondaMpolaId);  // Get total saved amount
        $balance = $userTargetAmount->targetAmount - ($totalSaved + $actualAmount);

        // insert record
        $isSaved = DB::table('sonda_mpola_payments')->insert([
            'sondaMpolaId' => $sondaMpolaId,
            'amount' => $amount,
            'payment_option' => $paymentOption,
            'currency' => 'UGX',
            'actual_amount' => $actualAmount,
            'balance' => $balance,
            'receipted_by' => $authId,
            'created_at' => now()->setTimezone('Africa/Nairobi'),
            'updated_at' => now()->setTimezone('Africa/Nairobi'),
        ]);

        if ($isSaved) {
            // Redirect with a success message
            return redirect()->back()->with('success', 'Sonda Mpola Payment record saved successfully!');
        } else {
            // Return with an error message
            return redirect()->back()->with('error', 'Failed to save Sonda Mpola payment record. Please try again.');
        }
    }

    function getTotalAmountUserHasSaved($sondaMpolaId)
    {
        // Sum all 'actual_amount' for the specified sondaMpolaId
        $totalAmountSaved = DB::table('sonda_mpola_payments')
            ->where('sondaMpolaId', '=', $sondaMpolaId)
            ->sum('actual_amount');  // use the sum() method

        return $totalAmountSaved;
    }

    public function updatePaymentStatusAndTargetAmountStatus(Request $request)
    {
        $paymentId = $request->paymentId;
        $sondaMpolaId = $request->sondaMpolaId;
        $payment_status = $request->payment_status;
        $targetAmountStatus = $request->targetAmountStatus;

        $updated = DB::table('sonda_mpola_payments')
            ->where('sonda_mpola_payments.id', '=', $paymentId)
            ->where('sonda_mpola_payments.sondaMpolaId', '=', $sondaMpolaId)
            ->update([
                "payment_status" => $payment_status,
                "target_amount_status" => $targetAmountStatus,
                'updated_at' => now()->setTimezone('Africa/Nairobi'),
            ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Sonda Mpola payment status updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Sonda Mpola payment status not updated.');
        }
    }

    public function generateSondaMpolaReceipt(Request $request)
    {
        $authId = $request->authId;
        $sondaMpolaId = $request->sondaMpolaId;
        $paymentId = $request->paymentId;

        // Update the issuedBy field and check if the update was successful
        $updated = DB::table('sonda_mpola_payments')
            ->where('sonda_mpola_payments.id', '=', $paymentId)
            ->where('sonda_mpola_payments.sondaMpolaId', '=', $sondaMpolaId)
            ->update([
                "issuedBy" => $authId,
            ]);

        // Fetch a single record
        $record = DB::table('sonda_mpola_payments')
            ->join('sonda_mpolas', 'sonda_mpolas.id', '=', 'sonda_mpola_payments.sondaMpolaId')
            ->join('users', 'users.id', '=', 'sonda_mpola_payments.issuedBy')
            ->select(
                'sonda_mpolas.name',
                'sonda_mpolas.reference',
                'sonda_mpolas.umrahSavingTarget',
                'sonda_mpolas.hajjSavingTarget',
                'sonda_mpola_payments.payment_option',
                'sonda_mpola_payments.actual_amount',
                'sonda_mpola_payments.balance',
                'users.name as issuedBy'
            )
            ->where('sonda_mpola_payments.sondaMpolaId', '=', $sondaMpolaId)
            ->where('sonda_mpola_payments.id', '=', $paymentId)
            ->first();

        $amountDepositedUptodate = $this->getTotalAmountUserHasSaved($sondaMpolaId);  // Get total saved amount

        if (!$record) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Generate the PDF content
        $pdf = Pdf::loadView('sonda_mpola.sonda_mpola_receipt', [
            'name' => $record->name,
            'reference' => $record->reference,
            'sondaMpolaTarget' => $record->umrahSavingTarget ?? $record->hajjSavingTarget,
            'modeOfPayment' => $record->payment_option,
            'amountDeposited' => $record->actual_amount,
            'balance' => $record->balance,
            'amountDepositedUptodate' => $amountDepositedUptodate,
            'issuedBy' => $record->issuedBy,
            'currentDate' => now('Africa/Nairobi')->format('d/m/Y')
        ]);

        $fileName = Str::slug($record->name) . '-' . now('Africa/Nairobi')->format('d-m-Y') . '-sonda-mpola-receipt.pdf';

        return $pdf->download($fileName);
    }
}
