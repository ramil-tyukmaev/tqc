<?php

namespace App\Jobs;

use App\Enum\TaskStatus;
use App\Models\Task;
use App\Services\AudioDownloader;
use App\Services\TranscriptionClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendToTranscription implements ShouldQueue
{
    use Queueable;
    protected $task;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $audioPath = AudioDownloader::download($this->task->audio_url);

        $transcriptionTaskId = TranscriptionClient::send($audioPath, $this->task->id);

        if (empty($transcriptionTaskId)) {
            $this->task->status = TaskStatus::ERROR;
            Log::channel('task_logger')->error('Отсутствует идентификатор задачи на транскрибацию',['task_id' => $this->task->id]);
        } else {
            $this->task->status = TaskStatus::TRANSCRIPTION;
            $this->task->transcription_task_id = $transcriptionTaskId;
        }

        $this->task->save();
    }
}
