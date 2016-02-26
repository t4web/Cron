<?php

namespace T4web\CronTest\Job;

use Cron\Report\JobReport;
use Cron\Schedule\CrontabSchedule;
use T4web\Cron\Job\ShellJob;

class ShellJobTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $job = new ShellJob(
            'job1',
            'ls -la',
            new CrontabSchedule('* * * * *')
        );

        $this->assertEquals('job1', $job->getId());
        $this->assertInstanceOf(JobReport::class, $job->getReport());
    }
}
