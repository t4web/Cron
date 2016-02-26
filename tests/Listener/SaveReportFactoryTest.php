<?php

namespace T4web\CronTest\Listener;

use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\Cron\Listener\SaveReport;
use T4web\Cron\Listener\SaveReportFactory;
use T4web\Cron\Log\LoggerInterface;

class SaveReportFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $factory = new SaveReportFactory();

        $serviceLocator->get(LoggerInterface::class)->willReturn($this->prophesize(LoggerInterface::class)->reveal());

        $listener = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($listener instanceof SaveReport);
    }
}
