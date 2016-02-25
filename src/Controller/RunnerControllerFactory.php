<?php

namespace T4web\Cron\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\Cron\Service\CronService;

class RunnerControllerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $cm
     * @return RunnerController
     */
    public function createService(ServiceLocatorInterface $cm)
    {
        $sl = $cm->getServiceLocator();

        return new RunnerController(
            $sl->get(CronService::class)
        );
    }
}
