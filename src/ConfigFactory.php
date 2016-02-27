<?php

namespace T4web\Cron;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use T4web\Cron\Log\FileSystem;

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
            $serviceLocator->get(FileSystem::class)
        );
    }
}
