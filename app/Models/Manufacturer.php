<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['manufacturer_name'];

    public function assetDetails()
    {
        return $this->hasMany(Asset_details::class, 'manufacturer');
    }
}
