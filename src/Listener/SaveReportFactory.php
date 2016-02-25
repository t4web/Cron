<?php
namespace T4web\Cron\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use T4web\Cron\Log\LoggerInterface;

class SaveReportFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return SaveReport
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new SaveReport(
            $serviceLocator->get(LoggerInterface::class)
        );
    }
}
