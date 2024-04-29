<?php

namespace LukeWaite\MonologMemoryUsageProcessor;

use Monolog\Level;
use Monolog\LogRecord;
use Monolog\Processor\MemoryProcessor;

class MemoryUsageProcessor extends MemoryProcessor
{
    public function __construct($useFormatting = true)
    {
        parent::__construct(true, $useFormatting);
    }

    public function __invoke(LogRecord $record)
    {
        $usage = memory_get_usage(false);
        $usageReal = memory_get_usage(true);

        $peak = memory_get_peak_usage(false);
        $peakReal = memory_get_peak_usage(true);

        $record = $record->toArray();
        $record['extra']['memory_usage'] = $this->formatBytes($usage);
        $record['extra']['memory_usage_real'] = $this->formatBytes($usageReal);
        $record['extra']['memory_peak_usage'] = $this->formatBytes($peak);
        $record['extra']['memory_peak_usage_real'] = $this->formatBytes($peakReal);

        return $this->toLogRecord($record);
    }

    private function toLogRecord(array $record): LogRecord
    {
        return new LogRecord(
            datetime: $record['datetime'],
            channel: $record['channel'],
            level: Level::tryFrom($record['level']),
            message: $record['message'],
            context: $record['context'],
            extra: $record['extra'],
            formatted: $record['formatted'] ?? null
        );
    }
}
