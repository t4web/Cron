<?php

namespace T4web\Cron\Resolver;

use Cron\Job\JobInterface;
use Cron\Schedule\CrontabSchedule;
use Cron\Resolver\ResolverInterface;
use T4web\Cron\Job\ShellJob;
use T4web\Cron\Exception\RuntimeException;

class ArrayResolver implements ResolverInterface
{
    /**
     * @var JobInterface[]
     */
    protected $jobs;

    /**
     * @var string
     */
    private $phpPath;

    /**
     * @var string
     */
    private $scriptPath;

    /**
     * @param $phpPath
     * @param $scriptPath
     */
    public function __construct($phpPath, $scriptPath)
    {
        $this->phpPath = $phpPath;
        $this->scriptPath = $scriptPath;
    }

    /**
     * @param array $rawJobs
     * @return JobInterface[]
     * @throws RuntimeException
     */
    public function buildFromConfig(array $rawJobs)
    {
        $jobs = [];
        foreach ($rawJobs as $jobArray) {

            $this->validateJob($jobArray);

            $job = new ShellJob(
                $jobArray['id'],
                $this->assembleShellJobString($jobArray['command']),
                new CrontabSchedule($jobArray['schedule'])
            );

            $this->jobs[] = $job;
        }

        return $jobs;
    }

    /**
     * @param array $jobArray
     * @throws RuntimeException
     */
    private function validateJob(array $jobArray)
    {
        if (!isset($jobArray['id'])) {
            throw new RuntimeException(sprintf("Job %s must contain ID", $jobArray['command']));
        }

        if (!isset($jobArray['command'])) {
            throw new RuntimeException(sprintf("Job %s must contain command", $jobArray['id']));
        }

        if (!isset($jobArray['schedule'])) {
            throw new RuntimeException(sprintf("Job %s must contain schedule", $jobArray['command']));
        }
    }

    /**
     * @param $command
     * @return string
     */
    private function assembleShellJobString($command)
    {
        return $this->phpPath . ' ' . $this->scriptPath . $command;
    }

    /**
     * @return JobInterface[]
     */
    public function resolve()
    {
        $jobs = array();
        $now = new \DateTime();

        foreach ($this->jobs as $job) {
            if ($job->valid($now)) {
                $jobs[] = $job;
            }
        }

        return $jobs;
    }
}
