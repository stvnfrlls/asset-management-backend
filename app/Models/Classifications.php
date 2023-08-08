<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classifications extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['class_name'];

    public function assetDetails()
    {
        return $this->hasMany(AssetDetails::class, 'classification');
    }
}
