<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TradeLicensePayment extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts()
    {
        return [
            'amount' => 'decimal:2',
            'fields' => 'array',
        ];
    }

    public function tradeLicenseApplication(){
        return $this->belongsTo(TradeLicenseApplication::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('form-fee-payment-slip')->singleFile();
        $this->addMediaCollection('license-fee-payment-slip')->singleFile();
    }
}
