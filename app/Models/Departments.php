<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departments extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['dept_name'];

    public function transferLists()
    {
        return $this->hasMany(TransferList::class, 'department');
    }
}
