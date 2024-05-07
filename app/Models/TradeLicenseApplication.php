<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TradeLicenseApplication extends Model
{
    use HasFactory, LogsActivity;

    const PENDING_FORM_FEE_PAYMENT = 'pending_form_fee_payment';
    const PENDING_FORM_FEE_VERIFICATION = 'pending_form_fee_verification';
    const PENDING_ASSISTANT_APPROVAL = 'pending_assistant_approval';
    const DENIED_ASSISTANT_APPROVAL = 'denied_assistant_approval';
    const PENDING_INSPECTOR_APPROVAL = 'pending_inspector_approval';
    const DENIED_INSPECTOR_APPROVAL = 'denied_inspector_approval';
    const PENDING_LICENSE_FEE_PAYMENT = 'pending_license_fee_payment';
    const PENDING_LICENSE_FEE_VERIFICATION = 'pending_license_fee_verification';
    const PENDING_SUPT_APPROVAL = 'pending_supt_approval';
    const DENIED_SUPT_APPROVAL = 'denied_supt_approval';
    const PENDING_RO_APPROVAL = 'pending_ro_approval';
    const DENIED_RO_APPROVAL = 'denied_ro_approval';

    const PENDING_INSPECTOR_RENEWAL_APPROVAL = 'pending_inspector_renewal_approval';
    const DENIED_INSPECTOR_RENEWAL_APPROVAL = 'denied_inspector_renewal_approval';
    const PENDING_LICENSE_RENEWAL_FEE_PAYMENT = 'pending_license_renewal_fee_payment';
    const PENDING_LICENSE_RENEWAL_FEE_VERIFICATION = 'pending_license_renewal_fee_verification';
    const PENDING_SUPT_RENEWAL_APPROVAL = 'pending_supt_renewal_approval';
    const DENIED_SUPT_RENEWAL_APPROVAL = 'denied_supt_renewal_approval';
    const PENDING_RO_RENEWAL_APPROVAL = 'pending_ro_renewal_approval';
    const DENIED_RO_RENEWAL_APPROVAL = 'denied_ro_renewal_approval';

    const ISSUED = 'issued';
    const RENEWED = 'renewed';
    const CANCELLED = 'cancelled';
    const EXPIRED = 'expired';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    //attribute casting
    protected function casts(): array
    {
        return [
            'birth_registration_no' => 'string',
            'national_id_no' => 'string',
            'passport_no' => 'string',
            'business_starting_date' => 'date',
            'trade_license_no' => 'string',
            'issued_at' => 'datetime',
            'expiry_date' => 'date',
            'corrections' => 'collection',
        ];
        
    }

    protected function businessOrganizationName(): Attribute {
        return Attribute::make(
            set: fn (string $value) => ucwords($value),
        );
    }

    protected function ownerName(): Attribute {
        return Attribute::make(
            set: fn (string $value) => ucwords($value),
        );
    }

    protected function fatherName(): Attribute {
        return Attribute::make(
            set: fn (string $value) => ucwords($value),
        );
    }

    protected function motherName(): Attribute {
        return Attribute::make(
            set: fn (string $value) => ucwords($value),
        );
    }

    protected function spouseName(): Attribute {
        return Attribute::make(
            set: fn (string $value) => ucwords($value),
        );
    }

    //relationships
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function documents(){
        return $this->hasMany(TradeLicenseDocument::class);
    }
    
    public function payments(){
        return $this->hasMany(TradeLicensePayment::class);
    }

    public function tlActivities(){
        return $this->hasMany(TradeLicenseActivity::class);
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    //activity logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    //custom methods
    public function isValid(): bool
    {
        return $this->status === self::ISSUED && $this->expiry_date->isFuture();
    }
    public function isValidForRenewal(): bool
    {
        return $this->status === self::ISSUED && $this->expiry_date->isToday();
    }

    public function expire()
    {
        $this->update([
            'issued_at' => null,
            'expiry_date' => null,
            'status' => self::EXPIRED,
        ]);
    }

}
