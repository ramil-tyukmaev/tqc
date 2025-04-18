<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'status',
        'audio_url',
        'transcription_task_id',
        'transcription_result',
        'assessment_result',
    ];
}
