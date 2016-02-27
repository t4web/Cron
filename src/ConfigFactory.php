<?php

namespace T4web\Cron;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Cron\Cron;
use T4web\Cron\Resolver\ArrayResolver;
use T4web\Cron\Executor\Executor;
use T4web\Cron\Config;

class ConfigFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Config
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appConfig = $serviceLocator->get('Config');
        $config = [];
        if (isset($appConfig['cron'])) {
            $config = $appConfig['cron'];
        }

        return new Config(
            $config,
            new FileSystem()
        );
    }
}
