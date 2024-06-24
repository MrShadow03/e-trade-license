<?php

namespace App\Models;

use Attribute;
use App\Helpers\Helpers;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Observers\TradeLicenseApplicationObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TradeLicenseApplication extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

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
            'corrections' => 'array',
        ];
    }

    // initialize observer
    protected static function boot(){
        parent::boot();
        self::observe(TradeLicenseApplicationObserver::class);
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

    public function signboard(){
        return $this->belongsTo(Signboard::class);
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    public function amendmentApplications(){
        return $this->hasMany(AmendmentApplication::class);
    } 

    public function canBeRenewed(): bool{
        return $this->trade_license_no && $this->issued_at && $this->status !== Helpers::ISSUED;
    }

    //activity logs
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    //custom methods
    public function isValid(): bool
    {
        return $this->status === Helpers::ISSUED && $this->expiry_date->isFuture();
    }
    public function isValidForRenewal(): bool
    {
        return $this->status === Helpers::ISSUED && $this->expiry_date->isToday();
    }

    public function expire()
    {
        $this->update([
            'issued_at' => null,
            'expiry_date' => null,
            'status' => Helpers::EXPIRED,
        ]);
    }

    public function isEditable(): bool{
        return auth()->user()->id == $this->user_id && $this->status === Helpers::PENDING_FORM_FEE_PAYMENT;
    }
    public function isDeletable(): bool{
        return auth()->user()->id == $this->user_id && $this->status === Helpers::PENDING_FORM_FEE_PAYMENT;
    }

    //amendment application
    public function hasActiveAmendment(): bool {
        return $this->amendmentApplications()->whereIn('status', [
            Helpers::PENDING_AMENDMENT_FEE_PAYMENT,
            Helpers::PENDING_AMENDMENT_FEE_VERIFICATION,
            Helpers::DENIED_AMENDMENT_FEE_VERIFICATION,
            Helpers::PENDING_AMENDMENT_APPROVAL,
            Helpers::DENIED_AMENDMENT_APPROVAL,
        ])->exists();
    }

    //Media Collections and Conversions
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('owner_image')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(60)
            ->height(60)
            ->nonQueued()
            ->performOnCollections('owner_image');
    }

    public function payFormFeeWithBank($amount){
        $payment = $this->payments()->create([
            'amount' => $amount,
            'method' => Helpers::BANK_PAYMENT,
            'type' => Helpers::FORM_FEE,
            'status' => 'pending',
        ]);

        $this->update([
            'status' => Helpers::PENDING_FORM_FEE_VERIFICATION,
        ]);

        return $payment;
    }

    public function isFormFeePayable(): bool{
        return $this->user_id === auth()->id() && ($this->status === Helpers::PENDING_FORM_FEE_PAYMENT || $this->status === Helpers::DENIED_FORM_FEE_VERIFICATION);
    }

    public function getActiveAmendment(){
        return $this->amendmentApplications()->whereIn('status', [
            Helpers::PENDING_AMENDMENT_FEE_PAYMENT,
            Helpers::PENDING_AMENDMENT_FEE_VERIFICATION,
            Helpers::DENIED_AMENDMENT_FEE_VERIFICATION,
            Helpers::PENDING_AMENDMENT_APPROVAL,
            Helpers::DENIED_AMENDMENT_APPROVAL,
        ])->first();
    }

    public function getTypeOfBusinessBnAttribute(){
        return $this->businessCategory?->name_bn ?? '';
    }

    public function getFormFeePayment(){
        return $this->payments()->where('type', Helpers::FORM_FEE)->first();
    }

    public function getAmendmentFeePayment(){
        return $this->payments()->where('type', Helpers::AMENDMENT_FEE)->latest()->first();
    }

    public function getLicenseFeePayment(){
        return $this->payments()->where('type', Helpers::LICENSE_FEE)->first();
    }

    public function getLicenseRenewalFeePayment(){
        return $this->payments()->where('type', Helpers::LICENSE_RENEWAL_FEE)->first();
    }

    public function getNewApplicationFeeAttribute(){
        return $this->businessCategory?->fee ?? 0;
    }

    public function getSignboardFeeAttribute(){
        return $this->signboard?->fee ?? 0;
    }

    public function getLatestActivityAttribute(){
        return $this->tlActivities()->latest()->first();
    }

    public function getIncomeTaxAmountAttribute(){
        $percentage = Helpers::INCOME_TAX_PERCENTAGE;
        $totalFee = $this->businessCategory->fee + $this->signboard->fee;
        return ($percentage / 100) * $totalFee;
    }

    public function getVatAmountAttribute(){
        $percentage = Helpers::VAT_PERCENTAGE;
        $totalFee = $this->businessCategory->fee + $this->signboard->fee;
        return ($percentage / 100) * $totalFee;
    }

    public function getSurchargeAmountAttribute(){
        $percentage = Helpers::SURCHARGE_PERCENTAGE;
        $totalFee = $this->businessCategory->fee + $this->signboard->fee;
        return ($percentage / 100) * $totalFee;
    }

    public function getTotalNewLicenseFeeAttribute(){
        return $this->new_application_fee + $this->signboard_fee + $this->income_tax_amount + $this->vat_amount;
    }

    public function getTotalLicenseRenewalFeeAttribute(){
        return $this->businessCategory?->fee + $this->signboard_fee + $this->income_tax_amount + $this->vat_amount + $this->surcharge_amount + $this->arrear_amount;
    }

    // public function getTotalRenewal

    public function getArrearAmountAttribute(){
        $amount = ($this->arrearDuration() - 1) * ($this->businessCategory?->fee + $this->signboard_fee + $this->income_tax_amount + $this->vat_amount + $this->surcharge_amount);

        return $amount > 0 ? $amount : 0;
    }

    public function arrearDuration() {
        $lastActivationYear = Helpers::getFiscalYear($this->issued_at);
        $currentFiscalYear = Helpers::getFiscalYear(now());

        return $currentFiscalYear - $lastActivationYear;
    }
}
