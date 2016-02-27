<?php

namespace T4web\CronTest\Log;

use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\Cron\Log\TextFile;
use T4web\Cron\Log\TextFileFactory;
use T4web\Cron\Config;

class TextFileFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $config = $this->prophesize(Config::class);

        $factory = new TextFileFactory();

        $serviceLocator->get(Config::class)->willReturn($config->reveal());

        $log = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($log instanceof TextFile);
    }
}
