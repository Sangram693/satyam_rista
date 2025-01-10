<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class User extends Model
{
    use HasFactory;

    // Allow mass assignment for specific attributes
    protected $guarded = [];

    /**
     * Define the relationship with the Zone model.
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'zone');
    }

    /**
     * The "booted" method of the model.
     * Automatically hash password and generate user_id.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            // Hash the password if it's not already hashed
            if (isset($user->password)) {
                $user->password = bcrypt($user->password);
            }

            // Generate a unique 8-digit random number for user_id
            if (empty($user->user_id)) {
                $user->user_id = self::generateUniqueUserId();
            }
        });

        static::updating(function ($user) {
            // Hash the password if it is updated and not already hashed
            if (isset($user->password) && !password_get_info($user->password)['algo']) {
                $user->password = bcrypt($user->password);
            }
        });
    }

    /**
     * Generate a unique 8-digit random user ID.
     */
    private static function generateUniqueUserId(): string
{
    do {
        // Generate an 8-character alphanumeric string
        $userId = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 8);
    } while (self::where('user_id', $userId)->exists());

    return $userId;
}

}
