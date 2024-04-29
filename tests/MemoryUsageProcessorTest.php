<?php

namespace Lukewaite\MonologMemoryUsageProcessor\Tests;

use LukeWaite\MonologMemoryUsageProcessor\MemoryUsageProcessor;
use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;
use PHPUnit\Framework\TestCase;

class MemoryUsageProcessorTest extends TestCase
{
    /**
     * Care of the monolog TestCase class
     */
    protected function getRecord($level = Logger::WARNING, $message = 'test', $context = []): LogRecord
    {
        return new LogRecord(
            message: $message,
            context: $context,
            level: Level::tryFrom($level),
            channel: 'test',
            datetime: new \DateTimeImmutable,
            extra: [],
        );
    }

    public function testProcessor()
    {
        $processor = new MemoryUsageProcessor;
        $record = $processor($this->getRecord());
        $this->assertWithFormatting($record, 'memory_usage');
        $this->assertWithFormatting($record, 'memory_usage_real');
        $this->assertWithFormatting($record, 'memory_peak_usage');
        $this->assertWithFormatting($record, 'memory_peak_usage');
    }

    public function testProcessorWithoutFormatting()
    {
        $processor = new MemoryUsageProcessor(false);
        $record = $processor($this->getRecord());
        $this->assertWithoutFormatting($record, 'memory_usage');
        $this->assertWithoutFormatting($record, 'memory_usage_real');
        $this->assertWithoutFormatting($record, 'memory_peak_usage');
        $this->assertWithoutFormatting($record, 'memory_peak_usage');
    }

    protected function assertWithFormatting($record, $key)
    {
        $this->assertArrayHasKey($key, $record['extra']);
        $this->assertMatchesRegularExpression('#[0-9.]+ (M|K)?B$#', $record['extra'][$key]);
    }

    protected function assertWithoutFormatting($record, $key)
    {
        $this->assertArrayHasKey($key, $record['extra']);
        $this->assertIsInt($record['extra'][$key]);
        $this->assertGreaterThan(0, $record['extra'][$key]);
    }
}
