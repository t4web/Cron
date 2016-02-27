<?php

namespace T4web\Cron\Log;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
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
        return new TextFile(
            new FileSystem(),
            $serviceLocator->get(Config::class)
        );
    }
}
