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

    protected $appends = ['pricing'];

    public function getPricingAttribute()
    {
        $pricing = [];

        if ($this->type === 'Standard') {
            $pricing[] = [
                'type' => 'Standard',
                'price' => $this->standardPrice
            ];
        } elseif ($this->type === 'Economy') {
            $pricing[] = [
                'type' => 'Economy',
                'price' => $this->economyPrice
            ];
        } elseif ($this->type === 'BOTH') {
            $pricing[] = [
                'type' => 'Standard',
                'price' => $this->standardPrice
            ];
            $pricing[] = [
                'type' => 'Economy',
                'price' => $this->economyPrice
            ];
        }

        return $pricing;
    }


    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'packageId', 'id');
    }
}
