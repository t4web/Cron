<?php

namespace T4web\Cron\Service;

use Cron\Cron;
use T4web\Cron\Exception\TimeoutException;

class CronService
{
    /**
     * @var integer
     */
    protected $timeout = null;

    /**
     * @var Cron
     */
    protected $cron = null;

    /**
     * @var int
     */
    protected $startTime = null;

    public function __construct($timeout, Cron $cron)
    {
        $this->timeout = $timeout;
        $this->cron = $cron;
    }

    public function run()
    {
        $this->startTime = time();

        $this->cron->run();
        $this->wait();
        $this->throwErrorIfTimeout();
    }

    protected function wait()
    {
        do {
            sleep(1);
        } while ($this->cron->isRunning() && !$this->checkTimeout());
    }

    protected function checkTimeout()
    {
        if (is_null($this->timeout)) {
            return false;
        }

        if ($this->timeout > (time() - $this->startTime)) {
            return false;
        }

        return true;
    }

    protected function throwErrorIfTimeout()
    {
        if ($this->checkTimeout()) {
            throw new TimeoutException($this->assembleErrorString());
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

        return $string . ' have taken over ' . $this->timeout . ' seconds to execute.';
    }
}
