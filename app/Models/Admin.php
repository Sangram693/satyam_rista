<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasApiTokens, HasFactory;

    protected $guarded = [];

    protected $table = 'admins';

    public function superAdmin()
    {
        return $this->belongsTo(SuperAdmin::class, 'super_admin_id');
    }

    public function salesmen()
    {
        return $this->hasMany(Salesman::class, 'admin_id');
    }

    public function creator()
    {
        return $this->belongsTo(SalesPerson::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(SalesPerson::class, 'updated_by');
    }
}
