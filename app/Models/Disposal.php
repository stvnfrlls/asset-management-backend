<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'method',
        'name',
        'date',
        'amount',
    ];

    public function asset()
    {
        return $this->belongsTo(Assets_details::class);
    }
    public function disposeMethod()
    {
        return $this->belongsTo(DisposalMethod::class);
    }
}
