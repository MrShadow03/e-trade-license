<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TradeLicenseDocument extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'trade_license_application_id',
        'trade_license_required_document_id',
        'document_name',
        'document_path'
    ];

    protected $casts = [
        'trade_license_application_id' => 'integer',
        'trade_license_required_document_id' => 'integer',
        'document_name' => 'string',
        'document_path' => 'string'
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('document-preview')
            ->width(300)
            ->height(300)
            ->nonQueued();
    }

    public function requiredDocument()
    {
        return $this->belongsTo(TradeLicenseRequiredDocument::class, 'trade_license_required_document_id');
    }

    public function getDocumentNameAttribute(){
        return $this->requiredDocument?->document_name;
    }
}
