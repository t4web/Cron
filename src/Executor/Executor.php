<?php

namespace T4web\Cron\Executor;

use Zend\EventManager\EventManager;
use Cron\Job\JobInterface;
use Cron\Report\ReportInterface;
use Cron\Report\CronReport;
use Cron\Executor\ExecutorInterface;
use T4web\Cron\JobEndedEvent;
use T4web\Cron\Job\ShellJob;

class Executor implements ExecutorInterface
{
    /**
     * @var JobInterface[]
     */
    private $jobs;

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var array
     */
    private $processedJobs = [];

    /**
     * @param JobInterface[] $jobs
     *
     * @return ReportInterface
     */
    public function execute(array $jobs)
    {
        $report = new CronReport();

        $this->jobs = $jobs;
        $this->startProcesses($report);

        return $report;
    }

    /**
     * @param CronReport $report
     */
    protected function startProcesses(CronReport $report)
    {
        foreach ($this->jobs as $job) {
            $report->addJobReport($job->getReport());
            // :) brilliantly
            $job->run($job->getReport());
        }
    }

    private function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new EventManager();
            $this->eventManager->setIdentifiers(get_class($this));
        }

        return $this->eventManager;
    }

    /**
     * @return bool
     */
    public function isRunning()
    {
        $isRunning = false;

        foreach ($this->jobs as $id => $job) {
            if ($job->isRunning()) {
                $isRunning = true;
            } else {

                if (isset($this->processedJobs[$id])) {
                    continue;
                }

                $event = new JobEndedEvent();
                $event->setTarget($this);
                $event->setJob($job);
                $event->setReport($job->getReport());
                $this->getEventManager()->trigger($event);

                $this->processedJobs[$id] = true;
            }
        }

        return $isRunning;
    }

    /**
     * @return ShellJob[]
     */
    public function getRunningJobs()
    {
        $jobs = [];
        foreach ($this->jobs as $job) {
            if ($job->isRunning()) {
                $jobs[] = $job;
            }
        }

        return $jobs;
    }
}
