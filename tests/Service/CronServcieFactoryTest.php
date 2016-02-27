<?php

namespace T4web\CronTest\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\Cron\Service\CronService;
use T4web\Cron\Service\CronServiceFactory;
use T4web\Cron\Config;

class CronServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $factory = new CronServiceFactory();

        $config = $this->prophesize(Config::class);

        $config->getPhpPath()->willReturn('php');
        $config->getScriptPath()->willReturn('/proj');
        $config->getJobs()->willReturn([]);
        $config->getTimeout()->willReturn(null);

        $serviceLocator->get(Config::class)->willReturn($config->reveal());

        $log = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($log instanceof CronService);
    }
}
