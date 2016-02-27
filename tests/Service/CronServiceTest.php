<?php

namespace T4web\CronTest\Service;

use Symfony\Component\Process\Process;
use Cron\Cron;
use T4web\Cron\Service\CronService;
use T4web\Cron\Exception\TimeoutException;
use T4web\Cron\Executor\Executor;
use T4web\Cron\Job\ShellJob;

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

    public function testRunWithTimeout()
    {
        $cron = $this->prophesize(Cron::class);
        $executor = $this->prophesize(Executor::class);
        $job = $this->prophesize(ShellJob::class);
        $process = $this->prophesize(Process::class);

        $cron->run()->willReturn(null);
        $cron->isRunning()->willReturn(false);

        $service = new CronService(0.5, $cron->reveal());

        $jobs = [$job->reveal()];
        $process->getCommandLine()->willReturn('ls -la');
        $job->getProcess()->willReturn($process->reveal());
        $executor->getRunningJobs()->willReturn($jobs);
        $cron->getExecutor()->willReturn($executor->reveal());

        $this->setExpectedException(TimeoutException::class);

        $service->run();
    }
}
