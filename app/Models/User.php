<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, LogsActivity, InteractsWithMedia;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone_verified_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function isVerified(): bool
    {
        return $this->phone_verified_at !== null;
    }

    public function markPhoneAsVerified(): void
    {
        $this->phone_verified_at = now();
        $this->save();
    }

    public function tradeLicenseApplications()
    {
        return $this->hasMany(TradeLicenseApplication::class);
    }
    
    public function otp()
    {
        return $this->hasOne(UserOneTimePassword::class);
    }

    public function markUserPhoneAsVerified()
    {
        $this->phone_verified_at = now();
        $this->save();
    }

    public function hasPurePassword(): bool
    {
        return $this->needs_password_reset == false;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('dp')
            ->singleFile();

        $this->addMediaConversion('thumb')
            ->width(60)
            ->height(60)
            ->nonQueued();
    }
}
