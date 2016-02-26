<?php

namespace T4web\CronTest\Listener;

use Cron\Report\JobReport;
use T4web\Cron\Listener\SaveReport;
use T4web\Cron\Log\LoggerInterface;
use T4web\Cron\JobEndedEvent;
use T4web\Cron\Job\ShellJob;

class SaveReportTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $event = $this->prophesize(JobEndedEvent::class);
        $report = $this->prophesize(JobReport::class);
        $job = $this->prophesize(ShellJob::class);

        $saveReport = new SaveReport($logger->reveal());

        $event->getReport()->willReturn($report->reveal());
        $job->getId()->willReturn('job1');
        $event->getJob()->willReturn($job->reveal());
        $time = time();
        $report->getStartTime()->willReturn($time);
        $report->getEndTime()->willReturn($time);
        $report->isSuccessful()->willReturn(true);
        $report->getOutput()->willReturn('');
        $report->getError()->willReturn('');

        $logger->log('job1', $time, $time, true, '', '')->willReturn(null);

        $saveReport($event->reveal());
    }
}
