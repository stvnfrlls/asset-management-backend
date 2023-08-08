<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoles extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['role'];

    public function transferList()
    {
        return $this->hasMany(TransferList::class, 'role_id');
    }
}
