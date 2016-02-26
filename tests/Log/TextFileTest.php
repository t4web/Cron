<?php

namespace T4web\CronTest\Log;

use T4web\Cron\Log\TextFile;
use T4web\Cron\Log\FileSystem;
use Prophecy\Argument;

class SaveReportTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $logDirectory ='/some/dir';
        $filesystem = $this->prophesize(FileSystem::class);

        $filesystem->isWritable('/some/dir')->willReturn(true);

        $service = new TextFile($filesystem->reveal(), $logDirectory);

        $filesystem->put('/some/dir/job1.log', Argument::type('string'))->willReturn(null);

        $service->log('job1', time(), time(), true, '', '');
    }
}
