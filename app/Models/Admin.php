<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Helpers\Helpers;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Services\TradeLicenseApplicationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Admin extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, LogsActivity, InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
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
        ];
    }

    // relations
    public function wards(){
        return $this->belongsToMany(Ward::class);
    }

    public function regions() {
        return $this->hasManyThrough(Region::class, Ward::class);
    }

    public function tradeLicenseApplications() {
        return TradeLicenseApplication::whereHas('ward', function ($query) {
            $query->whereHas('admins', function ($query) {
                $query->where('admin_id', $this->id);
            });
        })->get();
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()->logFillable();
    }

    public function getPendingApplicationCount(): int {
        $accessibleApplicationStatuses = TradeLicenseApplicationService::getAccessibleApplicationStatuses();
        return $this->tradeLicenseApplications()->whereIn('status', $accessibleApplicationStatuses)->whereIn('ward_no', $this->getWards())->count();
    }

    public function getPendingAmendmentApplicationCount(): int {
        $canApprove = $this->can('approve-pending-amendment-approval-applications');
        
        if(!$canApprove) return 0;

        return TradeLicenseApplication::whereHas('amendmentApplications', function($query) {
            $query->whereIn('status', [
                Helpers::PENDING_AMENDMENT_FEE_VERIFICATION,
                Helpers::PENDING_AMENDMENT_APPROVAL,
            ]);
        })->whereIn('ward_no', $this->getWards())->count();
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

    public function syncWards(array $wards){
        //detach all wards
        $this->wards()->detach();

        foreach($wards as $ward){
            $this->wards()->attach($ward);
        }
    }

    public function getWards(){
        return $this->wards->pluck('ward_no')->toArray();
    }
}
