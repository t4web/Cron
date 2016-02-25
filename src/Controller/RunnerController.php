<?php

namespace T4web\Cron\Controller;

use RuntimeException;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use T4web\Cron\Service\CronService;

class RunnerController extends AbstractActionController
{
    /**
     * @var CronService
     */
    private $cronService;

    public function __construct(CronService $cronService)
    {
        $this->cronService = $cronService;
    }

    public function onDispatch(MvcEvent $e)
    {
        if (!$e->getRequest() instanceof ConsoleRequest) {
            throw new RuntimeException('Only requests form console are allowed.');
        }

        $this->cronService->run();
    }
}
