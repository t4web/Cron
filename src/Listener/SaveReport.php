<?php

namespace T4web\Cron\Listener;

use T4web\Cron\JobEndedEvent;
use T4web\Cron\Log\LoggerInterface;

class SaveReport
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(JobEndedEvent $e)
    {
        $report = $e->getReport();

        $this->logger->log(
            $e->getJob()->getId(),
            $report->getStartTime(),
            $report->getEndTime(),
            $report->isSuccessful(),
            $report->getOutput(),
            $report->getError()
        );

    }
}
