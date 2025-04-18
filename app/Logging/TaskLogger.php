<?php

namespace App\Logging;

use App\Models\TaskLog;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class TaskLogger extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    public function __invoke(array $config)
    {
        $logger = new Logger('task_logger');
        $logger->pushHandler($this);

        return $logger;
    }

    protected function write(LogRecord $record): void
    {
        TaskLog::create([
            'description' => $record['message'],
            'task_id' => $record['context']['task_id'] ?? null,
            'data' => $record['context']['data'] ?? null,
        ]);
    }
}


