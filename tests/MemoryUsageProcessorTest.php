<?php

namespace Lukewaite\MonologMemoryUsageProcessor\Tests;

use LukeWaite\MonologMemoryUsageProcessor\MemoryUsageProcessor;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class MemoryPeakUsageProcessorTest extends TestCase
{
    /**
     * Care of the monolog TestCase class
     *
     * @return array Record
     */
    protected function getRecord($level = Logger::WARNING, $message = 'test', $context = array())
    {
        return array(
            'message' => $message,
            'context' => $context,
            'level' => $level,
            'level_name' => Logger::getLevelName($level),
            'channel' => 'test',
            'datetime' => \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true))),
            'extra' => array(),
        );
    }

    public function testProcessor()
    {
        $processor = new MemoryUsageProcessor();
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

    protected function assertWithFormatting($record, $key) {
        $this->assertArrayHasKey($key, $record['extra']);
        $this->assertRegExp('#[0-9.]+ (M|K)?B$#', $record['extra'][$key]);
    }

    protected function assertWithoutFormatting($record, $key) {
        $this->assertArrayHasKey($key, $record['extra']);
        $this->assertInternalType('int', $record['extra'][$key]);
        $this->assertGreaterThan(0, $record['extra'][$key]);
    }
}
