<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['status_name'];

    public function transferList()
    {
        return $this->hasMany(TransferList::class, 'status_id');
    }
}
