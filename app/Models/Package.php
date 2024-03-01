<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'id',
        'category',
        'type',
        'standardPrice',
        'economyPrice',
        'title',
        'dateRange',
        'packageImage',
        'endDateTime',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'packageId', 'id');
    }
}
