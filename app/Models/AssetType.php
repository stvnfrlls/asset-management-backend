<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['assetType_name'];

    protected $table = 'asset_types';

    public function assetDetails()
    {
        return $this->hasMany(AssetDetails::class, 'asset_type');
    }
}
