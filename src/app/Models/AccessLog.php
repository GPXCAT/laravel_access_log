<?php

namespace Gpxcat\LaravelAccessLog\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'member_id',
        'method',
        'url',
        'referer',
        'user_agent',
        'input',
        'ip',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'referer' => 'array',
        'input' => 'array',
    ];
}
