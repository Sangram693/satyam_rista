<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{
    /** @use HasFactory<\Database\Factories\SuperAdminFactory> */
    use HasFactory;

    protected $guarded = [];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'super_admin_id');
    }
}
