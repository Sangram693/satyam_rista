<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory;

    protected $guarded = [];

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
