<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupLog extends Model
{
    protected $fillable = [
        'filename',
        'size_bytes',
        'initiated_by',
        'type',
        'status',
        'notes',
    ];
}
