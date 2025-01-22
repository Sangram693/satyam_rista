<?php

namespace App\Models;

use App\Models\Zone;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DealerDistributor extends Model
{
    /** @use HasFactory<\Database\Factories\DealerDistributorFactory> */
    use HasApiTokens, HasFactory;

    protected $guarded = [];

    protected $hidden = ['password'];

    public function salesman()
    {
        return $this->belongsTo(Salesman::class);
    } 
    
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    protected $table = 'dealer_distributors';
}
