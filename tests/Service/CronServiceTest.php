<?php

namespace T4web\CronTest\Service;

use Cron\Cron;
use T4web\Cron\Service\CronService;

class CronServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $cron = $this->prophesize(Cron::class);

        $cron->run()->willReturn(null);
        $cron->isRunning()->willReturn(false);

        $service = new CronService(null, $cron->reveal());

        $service->run();
    }
}
