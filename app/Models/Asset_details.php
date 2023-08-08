<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset_details extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'asset_no',
        'img_url',
        'classification',
        'category',
        'asset_type',
        'manufacturer',
        'serial_no',
        'model',
        'description',
    ];

    public function transferLists()
    {
        return $this->hasMany(Transfer_list::class, 'asset_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer');
    }

    public function classification()
    {
        return $this->belongsTo(Classifications::class, 'classification');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function assetType()
    {
        return $this->belongsTo(AssetType::class, 'asset_type');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'asset_id');
    }

    public function location()
    {
        return $this->hasMany(LocationDetails::class, 'asset_id');
    }

    public function disposals()
    {
        return $this->hasMany(Disposal::class, 'asset_id');
    }

    public function deviceSpecs()
    {
        return $this->hasMany(Device_specs::class, 'asset_id');
    }
}
