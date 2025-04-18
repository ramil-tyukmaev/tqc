<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranscriptionClient
{
    static public function send($audioPath, $taskId): ?string
    {
        $response = Http::withHeaders([
            'X-Authorization' => env('TRANSCRIPTION_API_KEY'),
        ])->attach('audio', fopen($audioPath, 'r'), 'talk_example.mp3')
            ->beforeSending(function ($request) use ($taskId) {
                Log::channel('task_logger')->info('Запрос к сервису транскрибации', [
                    'task_id' => $taskId,
                    'data' => [
                        'url' => $request->url(),
                        'method' => $request->method(),
                        'headers' => $request->headers(),
                    ],
                ]);
            })
            ->asMultipart()
            ->post(env('TRANSCRIPTION_URL') . '/api/v1/audio/upload');

        Log::channel('task_logger')->info('Ответ от сервиса транскрибации', [
            'task_id' => $taskId,
            'data' => [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ],
        ]);

        if ($response->successful()) {
            $transcriptionTaskId = $response->json('id');
        }

        return $transcriptionTaskId ?? null;
    }

    static public function getStatus($transcriptionTaskId, $taskId): ?string
    {
        $response = Http::withHeaders([
            'X-Authorization' => env('TRANSCRIPTION_API_KEY'),
        ])
            ->beforeSending(function ($request) use ($taskId) {
                Log::channel('task_logger')->info('Запрос к сервису транскрибации', [
                    'task_id' => $taskId,
                    'data' => [
                        'url' => $request->url(),
                        'method' => $request->method(),
                        'headers' => $request->headers(),
                    ],
                ]);
            })
            ->get(env('TRANSCRIPTION_URL') . '/api/v1/audio/status/' . $transcriptionTaskId);

        Log::channel('task_logger')->info('Ответ от сервиса транскрибации', [
            'task_id' => $taskId,
            'data' => [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ],
        ]);

        if ($response->successful()) {
            $transcriptionTaskStatus = $response->json('status');
        }

        return $transcriptionTaskStatus ?? null;
    }

    static public function getResult($transcriptionTaskId, $taskId): ?array
    {
        $response = Http::withHeaders([
            'X-Authorization' => env('TRANSCRIPTION_API_KEY'),
        ])
            ->beforeSending(function ($request) use ($taskId) {
                Log::channel('task_logger')->info('Запрос к сервису транскрибации', [
                    'task_id' => $taskId,
                    'data' => [
                        'url' => $request->url(),
                        'method' => $request->method(),
                        'headers' => $request->headers(),
                    ],
                ]);
            })
            ->get(env('TRANSCRIPTION_URL') . '/api/v1/audio/transcription/' . $transcriptionTaskId);

        Log::channel('task_logger')->info('Ответ от сервиса транскрибации', [
            'task_id' => $taskId,
            'data' => [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ],
        ]);

        if ($response->successful()) {
            $transcription = $response->json('transcription');
        }

        return $transcription ?? null;
    }
}
