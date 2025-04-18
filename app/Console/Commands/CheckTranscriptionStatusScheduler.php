<?php

namespace App\Console\Commands;

use App\Enum\TaskStatus;
use App\Jobs\CheckTranscriptionStatus;
use Illuminate\Console\Command;
use App\Models\Task;

class CheckTranscriptionStatusScheduler extends Command
{
    protected $signature = 'tasks:check-transcription-status';

    public function handle()
    {
        $tasks = Task::where('status', TaskStatus::TRANSCRIPTION);

        foreach ($tasks->lazy() as $task) {
            CheckTranscriptionStatus::dispatch($task);
        }
    }
}
