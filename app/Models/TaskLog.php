<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $fillable = [
        'task_id',
        'description',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
