<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Licensing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category',
        'software',
        'version',
        'license_key',
        'status',
    ];

    public function device_spec()
    {
        return $this->hasMany(Device_specs::class);
    }
}
