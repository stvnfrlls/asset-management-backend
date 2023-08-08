<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer_list extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'from',
        'site',
        'area',
        'responsible',
        'department',
        'role_id',
        'transferred_date',
        'status_id',
    ];

    public function asset_details()
    {
        return $this->belongsTo(Asset_details::class);
    }
    public function statusType()
    {
        return $this->belongsTo(StatusType::class);
    }
    public function UserRoles()
    {
        return $this->belongsTo(UserRoles::class);
    }
    public function department()
    {
        return $this->belongsTo(Departments::class);
    }
}
