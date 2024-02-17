<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaqamEx extends Model
{
    use HasFactory;

    protected $table = 'maqam_exes';

    protected $fillable = [
        'id',
        'thumbnail',
        'videoLink',
        'description',
        'detail',
    ];
}
