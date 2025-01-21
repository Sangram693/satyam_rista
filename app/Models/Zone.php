<?php

namespace App\Models;

use App\Models\DealerDistributor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    /** @use HasFactory<\Database\Factories\ZoneFactory> */
    use HasFactory;

    protected $guarded = [];

    public function salesmen()
    {
        return $this->hasMany(Salesman::class, 'zone');
    }

    public function dealerDistributors()
    {
        return $this->hasMany(DealerDistributor::class, 'zone');
    }
}
