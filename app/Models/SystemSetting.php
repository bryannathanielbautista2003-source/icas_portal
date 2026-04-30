<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = ['setting_key', 'setting_value', 'type', 'description'];

    public $timestamps = true;

    protected $casts = [
        'setting_value' => 'string',
    ];
}
