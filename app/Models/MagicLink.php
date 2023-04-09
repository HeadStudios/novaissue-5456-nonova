<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class MagicLink extends Model
{
    protected $fillable = [
        'user_id', 'token', 'expires_at'
    ];

    protected $dates = [
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generate(User $user, $expiresAt = null)
    {
        if (!$expiresAt) {
            $expiresAt = now()->addHour();
        }

        return self::create([
            'user_id' => $user->id,
            'token' => Str::random(64),
            'expires_at' => $expiresAt,
        ]);
    }

    public function isValid()
    {
        return $this->expires_at->gt(now());
    }
}
