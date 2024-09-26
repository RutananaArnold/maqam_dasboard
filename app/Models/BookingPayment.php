<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    use HasFactory;

    protected $table = 'booking_payments';

    protected $fillable = [
        'id',
        'bookingId',
        'amount',
        'payment_status',
        'paymentOption',
    ];
}
