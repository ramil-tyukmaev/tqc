<?php

namespace App\Services;

class AudioDownloader
{
    static public function download($url): string
    {
        return storage_path('app/private/talk_example.mp3');
    }
}
