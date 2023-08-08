<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisposalMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'method',
    ];

    public function disposal()
    {
        return $this->hasMany(Assets_details::class);
    }
}
