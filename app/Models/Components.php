<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Components extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'storage_type',
        'storage_size',
        'memory_type',
        'memory_size',
    ];

    public function device_spec()
    {
        return $this->belongsTo(Device_specs::class);
    }
}
