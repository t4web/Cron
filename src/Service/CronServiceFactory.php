<?php

namespace T4web\Cron\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Cron\Cron;
use T4web\Cron\Resolver\ArrayResolver;
use T4web\Cron\Executor\Executor;
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
        $config = $serviceLocator->get(Config::class);

        $resolver = new ArrayResolver($config->getPhpPath(), $config->getScriptPath());
        $resolver->buildFromConfig($config->getJobs());

        $cron = new Cron();
        $cron->setResolver($resolver);
        $cron->setExecutor(new Executor());

        return new CronService(
            $config->getTimeout(),
            $cron
        );
    }
}
