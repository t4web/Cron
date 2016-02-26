<?php

namespace T4web\CronTest\Eecutor;

use Cron\Report\CronReport;
use Cron\Report\JobReport;
use T4web\Cron\Executor\Executor;
use T4web\Cron\Job\ShellJob;

class ExecutorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Executor
     */
    private $executor;

    private $jobs = [];

    public function setUp()
    {
        $this->executor = new Executor();

        $this->jobs['job1'] = $this->prophesize(ShellJob::class);
        $this->jobs['job2'] = $this->prophesize(ShellJob::class);
        $this->jobs['job3'] = $this->prophesize(ShellJob::class);

        $job1Report =  new JobReport($this->jobs['job1']->reveal());
        $job2Report =  new JobReport($this->jobs['job2']->reveal());
        $job3Report =  new JobReport($this->jobs['job3']->reveal());

        $this->jobs['job1']->getReport()->willReturn($job1Report);
        $this->jobs['job2']->getReport()->willReturn($job2Report);
        $this->jobs['job3']->getReport()->willReturn($job3Report);

        $this->jobs['job1']->run($job1Report)->willReturn(null);
        $this->jobs['job2']->run($job2Report)->willReturn(null);
        $this->jobs['job3']->run($job3Report)->willReturn(null);
    }

    public function testExecute()
    {
        $report = $this->executor->execute([
            $this->jobs['job1']->reveal(),
            $this->jobs['job2']->reveal(),
            $this->jobs['job3']->reveal(),
        ]);

        $this->assertInstanceOf(CronReport::class, $report);
    }

    public function testIsRunning()
    {
        $this->executor->execute([
            $this->jobs['job1']->reveal(),
            $this->jobs['job2']->reveal(),
            $this->jobs['job3']->reveal(),
        ]);

        $this->jobs['job1']->isRunning()->willReturn(true);
        $this->jobs['job2']->isRunning()->willReturn(false);
        $this->jobs['job3']->isRunning()->willReturn(false);

        $this->assertTrue($this->executor->isRunning());
    }

    public function testIsNotRunning()
    {
        $this->executor->execute([
            $this->jobs['job1']->reveal(),
            $this->jobs['job2']->reveal(),
            $this->jobs['job3']->reveal(),
        ]);

        $this->jobs['job1']->isRunning()->willReturn(false);
        $this->jobs['job2']->isRunning()->willReturn(false);
        $this->jobs['job3']->isRunning()->willReturn(false);

        $this->assertFalse($this->executor->isRunning());
    }
}
