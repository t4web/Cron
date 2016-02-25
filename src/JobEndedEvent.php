<?php
namespace T4web\Cron;

use Zend\EventManager\Event;
use Cron\Report\JobReport;
use T4web\Cron\Job\ShellJob;

/**
 * Class AuthenticationEvent
 */
class JobEndedEvent extends Event
{
    /**
     * Events triggered by eventmanager
     */
    const EVENT_JOB_ENDED = 'cronjob-ended';

    /**
     * @var JobReport
     */
    private $report;

    /**
     * @var ShellJob
     */
    private $job;

    /**
     * Constructor
     *
     * Accept a target and its parameters.
     *
     * @param  string $name Event name
     * @param  string|object $target
     * @param  array|\ArrayAccess $params
     */
    public function __construct($name = null, $target = null, $params = null)
    {
        parent::__construct(self::EVENT_JOB_ENDED, $target, $params);
    }

    /**
     * @param JobReport $report
     * @return $this
     */
    public function setReport(JobReport $report)
    {
        $this->report = $report;
        return $this;
    }

    /**
     * @return JobReport
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * @return ShellJob
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param ShellJob $job
     * @return $this
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }
}
