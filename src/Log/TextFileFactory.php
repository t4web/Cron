<?php

namespace T4web\Cron\Log;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Cron\Cron;
use T4web\Cron\Resolver\ArrayResolver;
use T4web\Cron\Executor\Executor;
use T4web\Cron\Config;

class TextFileFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TextFile
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appConfig = $serviceLocator->get('Config');
        $logDirectory = null;
        if (isset($appConfig['cron']['log-directory'])) {
            $logDirectory = $appConfig['cron']['log-directory'];
        }

        return new TextFile($logDirectory);
    }
}
