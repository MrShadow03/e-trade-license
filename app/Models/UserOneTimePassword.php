<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserOneTimePassword extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    // // automatically create a 64 characters long 'otp_token' when creating a new record
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->otp_token = bin2hex(random_bytes(64));
    //     });
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['user_id', 'otp', 'expires_at', 'is_used', 'last_used_ip', 'last_used_at', 'left_attempts']);
    }

    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }

    public function hasAttempts(): bool
    {
        return $this->left_attempts > 0;
    }

    public function decrementAttempts(): void
    {
        $this->decrement('left_attempts');
    }

    public function isUsable(): bool
    {
        return !$this->isExpired() && $this->hasAttempts();
    }

    public function coolDown(): int
    {
        return now()->diffInSeconds($this->updated_at->addSeconds(config('constants.COOL_DOWN')));
    }
}
