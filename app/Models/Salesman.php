<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesman extends Model
{
    /** @use HasFactory<\Database\Factories\SalesmanFactory> */
    use HasFactory;

    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone');
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
