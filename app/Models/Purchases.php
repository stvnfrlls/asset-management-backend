<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchases extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'item_code',
        'company',
        'supplier',
        'amount',
        'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Assets_details::class);
    }
}
