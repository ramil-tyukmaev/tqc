<?php
namespace App\Enum;

enum TaskStatus: string {
    case NEW = 'new';
    case TRANSCRIPTION = 'transcription';
    case TRANSCRIPTION_COMPLETED = 'transcription completed';
    case COMPLETED = 'completed';
    case ERROR = 'error';
}
