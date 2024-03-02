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

        if ($this->type === 'STANDARD') {
            $pricing[] = [
                'type' => 'STANDARD',
                'price' => $this->standardPrice
            ];
        } elseif ($this->type === 'ECONOMY') {
            $pricing[] = [
                'type' => 'ECONOMY',
                'price' => $this->economyPrice
            ];
        } elseif ($this->type === 'BOTH') {
            $pricing[] = [
                'type' => 'STANDARD',
                'price' => $this->standardPrice
            ];
            $pricing[] = [
                'type' => 'ECONOMY',
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
