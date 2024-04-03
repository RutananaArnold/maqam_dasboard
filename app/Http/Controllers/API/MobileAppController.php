<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Booking;
use App\Models\BookingPayment;
use App\Models\MaqamEx;
use App\Models\Package;
use App\Models\User;
use Exception;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $passportPhoto = $request->passportPhoto;
        $packageId = $request->packageId;
        $ninOrPassport = $request->ninOrPassport;

        if (!empty($userId)) {
            // identify user
            $user = DB::table('users')->select('id', 'name', 'email', 'phone', 'role', 'gender', 'dob', 'nationality', 'residence', 'NIN_or_Passport', 'passportPhoto')->find($userId);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 400);
            }

            $existingUserId = $user->id;

            // get user passport photo
            $passportPhotoPath = $user->passportPhoto;
            $passportPhotoUrl = url('bookingImages/' . $passportPhotoPath);

            // Include the image URL in your response
            $user->passportPhoto = $passportPhotoUrl;

            // create a new booking
            $newBooking = new Booking();
            $newBooking->userId = $existingUserId;
            $newBooking->packageId = $packageId;
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

            // Decode base64 image string
            $decoded_file = base64_decode($passportPhoto); // decode the file
            $mime_type = finfo_buffer(finfo_open(), $decoded_file, FILEINFO_MIME_TYPE); // extract mime type
            $extension = $this->mime2ext($mime_type); // extract extension from mime type
            $file = uniqid() . '.' . $extension; // rename file as a unique name

            try {
                Storage::disk('booking_uploads')->put($file, $decoded_file);
            } catch (Exception $e) {
                //throw $th;
                echo json_encode($e->getMessage());
            }

            $id = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email ?? "example@gmail.com",
                'phone' => $phone,
                'password' => Hash::make($phone),
                'role' => 3,
                'gender' => $gender,
                'dob' => $dob ?? '12/01/1900',
                'nationality' => $nationality,
                'residence' => $residence,
                'NIN_or_Passport' => $ninOrPassport,
                'passportPhoto' => $file,
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime
            ]);

            $user = DB::table('users')->select('id', 'name', 'email', 'phone', 'role', 'gender', 'dob', 'nationality', 'residence', 'NIN_or_Passport', 'passportPhoto')->find($id);

            if (!$user) {
                return response()->json(['message' => 'User not found'], 400);
            }

            $passportPhotoPath = $user->passportPhoto;
            $passportPhotoUrl = url('bookingImages/' . $passportPhotoPath);

            // Include the image URL in your response
            $user->passportPhoto = $passportPhotoUrl;

            $newUserId = $user->id;
            // create a new booking
            $newBooking = new Booking();
            $newBooking->userId = $newUserId;
            $newBooking->packageId = $packageId;
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

    function mime2ext($mime)
    {
        $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
        "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
        "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
        "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
        "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
        "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
        "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
        "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
        "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
        "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
        "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
        "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
        "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
        "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
        "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
        "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
        "pdf":["application\/pdf","application\/octet-stream"],
        "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
        "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
        "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
        "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
        "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
        "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
        "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
        "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
        "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
        "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
        "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
        "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
        "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
        "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
        "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
        "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
        "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
        "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
        "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
        "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
        "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
        "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
        "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
        "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
        "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
        "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
        "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
        "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
        $all_mimes = json_decode($all_mimes, true);
        foreach ($all_mimes as $key => $value) {
            if (array_search($mime, $value) !== false) return $key;
        }
        return false;
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
            ->join('packages', 'packages.id', '=', 'bookings.packageId')
            ->join('booking_payments', 'booking_payments.bookingId', '=', 'bookings.id')
            ->select(
                'users.id as userId',
                'bookings.id as bookingId',
                'users.name',
                'users.phone',
                'users.email',
                'user_roles.Role',
                'users.gender',
                'users.dob',
                'users.nationality',
                'users.residence',
                'users.passportPhoto',
                'bookings.paymentOption',
                'packages.category',
                'bookings.created_at',
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

    public function updateBookingPayment(Request $request)
    {
        $request->validate([
            'bookingId' => 'required',
            "paymentOption" => 'required|string',
            'amount' => 'required|string'
        ]);
        $bookingId = $request['bookingId'];
        $paymentOption = $request['paymentOption'];
        $bookingAmount = $request['amount'];

        $payments = new BookingPayment();
        $payments->bookingId = $bookingId;
        $payments->amount = $bookingAmount;

        try {
            $payments->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Failed to save payment: " . $e->getMessage()
            ], 500);
        }


        $affectedBooking = Booking::where("id", $bookingId)->update(["paymentOption" => $paymentOption]);

        if ($affectedBooking) {
            return response()->json([
                'status' => true,
                'message' => "Payment Details updated"
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Payment Details failed to get updated"
            ], 400);
        }
    }

    public function getPackages(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', 10);

        $packages = Package::with('services')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        if ($packages->isNotEmpty()) {

            // Format package image URLs
            $packages->getCollection()->transform(function ($package) {
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
                'total' => $packages->total(),
                'current_page' => $packages->currentPage(),
                'packages' => $packages->items(),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No Packages found',
            ]);
        }
    }

    public function getPaymentHistory(Request $request)
    {
        $bookId = $request->bookingId;

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

        if ($payments->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'payments' => $payments,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No payments made yet',
            ],);
        }
    }

    public function fetchClientTravelDoc(Request $request)
    {
        $bookId = $request->bookingId;

        $booking = Booking::select('travelDocument')->where('bookings.id', $bookId)->first();

        if (!$booking) {
            return response()->json(['error' => 'Document path not found.'], 404);
        }
        $path = $booking->travelDocument;

        if ($path != null) {

            $filePath =  url('travelDocuments/' . $path);
            return response()->json([
                'status' => true,
                'file_path' => $filePath,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Travel Documents not yet uploaded.",
            ],);
        }
    }

    public function fetchAdverts(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', 10);

        $adverts = Advert::paginate($perPage, ['*'], 'page', $page);
        if ($adverts->isNotEmpty()) {
            $adverts->getCollection()->transform(function ($advert) {
                $advert->image = url('advertImages/' . $advert->image);
                return $advert;
            });

            return response()->json([
                'status' => true,
                'total' => $adverts->total(),
                'current_page' => $adverts->currentPage(),
                'adverts' => $adverts->items()
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No Adverts found',
            ]);
        }
    }

    public function fetchMaqamExperiences(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', 10);

        $experiences = MaqamEx::paginate($perPage, ['*'], 'page', $page);
        if ($experiences->isNotEmpty()) {
            $experiences->getCollection()->transform(function ($experience) {
                $experience->thumbnail = url('maqamExpImages/' . $experience->thumbnail);
                return $experience;
            });

            return response()->json([
                'status' => true,
                'total' => $experiences->total(),
                'current_page' => $experiences->currentPage(),
                'experiences' => $experiences->items()
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No Maqam Experiences found',
            ]);
        }
    }

    public function loginClientInApp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            "password" => 'required|string',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid phone number or password'], 401);
        }


        return response()->json([
            'message' => 'Successful login',
            'user' => $user,
        ], 200);
    }
}
