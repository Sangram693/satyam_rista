<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class SalesPerson extends Model
{
    /** @use HasFactory<\Database\Factories\SalesPersonFactory> */
    use HasApiTokens, HasFactory;

    protected $hidden = ['password', 'created_at', 'updated_at'];

    protected $guarded = [];

    public function createdAdmins()
    {
        return $this->hasMany(Admin::class, 'created_by');
    }

    public function updatedAdmins()
    {
        return $this->hasMany(Admin::class, 'updated_by');
    }

    public function createdSalesmen()
    {
        return $this->hasMany(Salesman::class, 'created_by');
    }

    public function updatedSalesmen()
    {
        return $this->hasMany(Salesman::class, 'updated_by');
    }
}
