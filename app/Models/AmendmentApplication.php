<?php

namespace App\Models;

use App\Observers\AmendmentApplicationObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AmendmentApplication extends Model implements HasMedia {
    use HasFactory, InteractsWithMedia;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function tradeLicenseApplication() {
        return $this->belongsTo(TradeLicenseApplication::class);
    }

        // initialize observer
        protected static function boot(){
            parent::boot();
            self::observe(AmendmentApplicationObserver::class);
        }

    public function registerMediaCollections(): void {
        $this->addMediaCollection('house-ownership-document')->singleFile();
        $this->addMediaCollection('owner-image')->singleFile();
        $this->addMediaCollection('owner-national-id')->singleFile();
        $this->addMediaCollection('ownership-transfer-deed')->singleFile();
        $this->addMediaCollection('old-house-ownership-document')->singleFile();
        $this->addMediaCollection('old-owner-image')->singleFile();
        $this->addMediaCollection('old-owner-national-id')->singleFile();
        $this->addMediaCollection('old-ownership-transfer-deed')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void{
        $this->addMediaConversion('document-preview')
            ->width(300)
            ->height(300)
            ->nonQueued()
            ->performOnCollections('house-ownership-document', 'owner-national-id', 'ownership-transfer-deed');
    }
}
