<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device_specs extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'license_id',
        'documentsuite_id',
        'component_id',
        'processor',
        'category',
        'os_prior_license_key',
    ];

    public function asset()
    {
        return $this->belongsTo(Assets_details::class);
    }
    public function license()
    {
        return $this->belongsTo(Licensing::class);
    }
    public function docsuite()
    {
        return $this->belongsTo(Licensing::class);
    }
    public function components()
    {
        return $this->belongsTo(components::class);
    }
}
