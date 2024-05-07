<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeLicenseDocument extends Model
{
    use HasFactory;

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
}
