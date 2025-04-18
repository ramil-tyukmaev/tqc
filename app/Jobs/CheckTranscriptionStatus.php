<?php

namespace App\Jobs;

use App\Enum\TaskStatus;
use App\Models\Task;
use App\Services\AudioDownloader;
use App\Services\LLMClient;
use App\Services\TranscriptionClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTranscriptionStatus implements ShouldQueue
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
        $status = TranscriptionClient::getStatus($this->task->transcription_task_id, $this->task->id);

        if ($status === 'completed') {

            $transcription = TranscriptionClient::getResult($this->task->transcription_task_id, $this->task->id);

            if (empty($transcription)) {
                $this->task->status = TaskStatus::ERROR;
                $this->task->save();
                Log::channel('task_logger')->error('Отсутствует результат транскрибации', ['task_id' => $this->task->id]);

                return;
            }

            $this->task->transcription_result = $transcription;
            $this->task->save();

            $assessment = LLMClient::send($transcription);

            $this->task->assessment_result = $assessment;
            $this->task->status = TaskStatus::COMPLETED;
            $this->task->save();
        }
    }
}
