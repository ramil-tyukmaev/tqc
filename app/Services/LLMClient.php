<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LLMClient
{
    static public function send($transcriptionData): array
    {
        return [
            'param1' => 1,
            'param2' => 2,
            'param3' => 3,
        ];
    }
}
