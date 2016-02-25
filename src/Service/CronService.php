<?php

namespace T4web\Cron\Service;

use Cron\Cron;
use Cron\Job\ShellJob;
use Cron\Schedule\CrontabSchedule;
use T4web\Cron\Config;
use T4web\Cron\Exception\TimeoutException;

class CronService
{
    /**
     * @var Config
     */
    protected $config = null;

    /**
     * @var Cron
     */
    protected $cron = null;

    /**
     * @var int
     */
    protected $startTime = null;

    public function __construct(Config $config, Cron $cron)
    {
        $this->config = $config;
        $this->cron = $cron;
    }

    public function run()
    {
        $this->startTime = time();

        $this->addJobs();

        /** @var \Cron\Report\CronReport $repo */
        $repo = $this->cron->run();
        $this->wait();
        //die(var_dump($repo->getReports()[0]->get));
        $this->throwErrorIfTimeout();
    }

    protected function addJobs()
    {
        foreach ($this->config->getJobs() as $jobArray) {
            $job = new ShellJob();
            $job->setCommand($this->assembleShellJobString($jobArray['command']));
            $job->setSchedule(new CrontabSchedule($jobArray['schedule']));

            $this->cron->getResolver()->addJob($job);
        }
    }

    protected function assembleShellJobString($command)
    {
        return $this->config->getPhpPath() . ' ' . $this->config->getScriptPath() . $command;
    }

    protected function wait()
    {
        do {
            sleep(1);
        } while ($this->cron->isRunning() && !$this->checkTimeout());
    }

    protected function checkTimeout()
    {
        $timeout = $this->config->getTimeout();

        if (is_null($timeout)) {
            return false;
        }

        if ($timeout > (time() - $this->startTime)) {
            return false;
        }

        return true;
    }

    protected function throwErrorIfTimeout()
    {
        if ($this->checkTimeout()) {
            throw new TimeoutException('Timeout Exception'/*$this->assembleErrorString()*/);
        }
    }

    protected function assembleErrorString()
    {
        $string = 'Jobs: ' . PHP_EOL;
        $i = 1;
        foreach ($this->cron->getExecutor()->getRunningJobs() as $job) {
            $string .= $i . '. ' . $job->getProcess()->getCommandLine() . PHP_EOL;
            $i++;
        }

        return $string . ' have taken over ' . $this->config->getTimeout() . ' seconds to execute.';
    }
}
