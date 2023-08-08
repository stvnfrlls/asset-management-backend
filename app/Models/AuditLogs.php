<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'audit_Name', 
        'audit_Page',
        'audit_itemNo', 
        'audit_action'
    ];

    protected $table = 'audit_log';
}
