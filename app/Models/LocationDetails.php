<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'site',
        'area',
        'responsible',
        'department',
        'role_id',
        'status_id',
        'remarks',
    ];

    public function asset()
    {
        return $this->belongsTo(Assets_details::class);
    }
}
