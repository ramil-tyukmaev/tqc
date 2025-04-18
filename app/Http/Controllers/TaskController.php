<?php

namespace App\Http\Controllers;

use App\Enum\TaskStatus;
use App\Jobs\SendToTranscription;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audioUrl' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Task::create([
            'audio_url' => $request->audioUrl,
            'status' => TaskStatus::NEW,
        ]);

        SendToTranscription::dispatch($task);

        return response()->json($task, 201);
    }
}
