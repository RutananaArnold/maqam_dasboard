<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MobileAppController extends Controller
{
    public function createBooking(Request $request)
    {
        $userId = $request->userId;
        $name = $request->name;
    }
}
