<?php

namespace T4web\Cron\Executor;

use Zend\EventManager\EventManager;
use Cron\Executor\Executor as BaseExecutor;
use T4web\Cron\JobEndedEvent;
use T4web\Cron\Job\ShellJob;

class Executor extends BaseExecutor
{
    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var array
     */
    private $processedJobs = [];

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

        foreach ($this->sets as $id => $set) {
            if ($set->getJob()->isRunning()) {
                $isRunning = true;
            } else {

                if (isset($this->processedJobs[$id])) {
                    continue;
                }

                $event = new JobEndedEvent();
                $event->setTarget($this);
                $event->setJob($set->getJob());
                $event->setReport($set->getReport());
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
        foreach ($this->sets as $set) {
            if ($set->getJob()->isRunning()) {
                $jobs[] = $set->getJob();
            }
        }

        return $jobs;
    }
}
