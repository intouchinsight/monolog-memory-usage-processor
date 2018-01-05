<?php

namespace LukeWaite\MonologMemoryUsageProcessor;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Ring\Core;
use GuzzleHttp\Ring\Future\CompletedFutureArray;
use GuzzleHttp\Ring\Future\FutureArrayInterface;
use Monolog\Processor\MemoryProcessor;

class MemoryUsageProcessor extends MemoryProcessor
{

    public function __construct( $useFormatting = true)
    {
        parent::__construct(true, $useFormatting);
    }

    public function __invoke(array $record)
    {
        $usage = memory_get_usage(false);
        $usageReal = memory_get_usage(true);

        $peak = memory_get_peak_usage(false);
        $peakReal = memory_get_peak_usage(true);

        $record['extra']['memory_usage'] = $this->formatBytes($usage);
        $record['extra']['memory_usage_real'] = $this->formatBytes($usageReal);
        $record['extra']['memory_peak_usage'] = $this->formatBytes($peak);
        $record['extra']['memory_peak_usage_real'] = $this->formatBytes($peakReal);

        return $record;
    }
}