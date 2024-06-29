<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function admins(){
        return $this->belongsToMany(Admin::class);
    }

    public function regions(){
        return $this->hasMany(Region::class);
    }

    public function tlApplications(){
        return $this->hasMany(TradeLicenseApplication::class, 'ward_no', 'ward_no');
    }
}
