<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    use HasFactory;

    // Allow mass assignment for all attributes
    protected $guarded = [];

    /**
     * Define the relationship with the User model.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'zone');
    }
}
