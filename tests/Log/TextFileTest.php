<?php

namespace T4web\CronTest\Log;

use T4web\Cron\Log\TextFile;
use T4web\Cron\Log\FileSystem;
use T4web\Cron\Config;
use Prophecy\Argument;

class SaveReportTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $filesystem = $this->prophesize(FileSystem::class);
        $config = $this->prophesize(Config::class);

        $config->getLogDirectory()->willReturn('/some/dir');

        $service = new TextFile($filesystem->reveal(), $config->reveal());

        $filesystem->put('/some/dir/job1.log', Argument::type('string'))->willReturn(null);

        $service->log('job1', time(), time() + (3600 * 28 + 11), true, '', '');
    }
}
