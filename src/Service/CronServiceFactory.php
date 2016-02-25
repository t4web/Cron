<?php

namespace T4web\Cron\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Cron\Cron;
use Cron\Resolver\ArrayResolver;
use Cron\Executor\Executor;
use T4web\Cron\Config;

class CronServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CronService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appConfig = $serviceLocator->get('Config');
        $config = [];
        if (isset($appConfig['cron'])) {
            $config = $appConfig['cron'];
        }

        $cron = new Cron();
        $cron->setResolver(new ArrayResolver());
        $cron->setExecutor(new Executor());

        return new CronService(
            new Config($config),
            $cron
        );
    }
}
