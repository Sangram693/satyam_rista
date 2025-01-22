<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    /** @use HasFactory<\Database\Factories\BillFactory> */
    use HasFactory;

    protected $guarded = [];

    public function dealerDistributor()
    {
        return $this->belongsTo(DealerDistributor::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bill) {
            $bill->transaction_id = Str::random(16);
        });
    }
}
