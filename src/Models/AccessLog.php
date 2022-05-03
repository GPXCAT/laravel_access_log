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
        'guards',
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
        'guards' => 'array',
        'referer' => 'array',
        'input' => 'array',
    ];
}
