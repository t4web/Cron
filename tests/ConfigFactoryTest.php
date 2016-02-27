<?php

namespace T4web\CronTest;

use Zend\ServiceManager\ServiceLocatorInterface;
use Prophecy\Argument;
use T4web\Cron\Config;
use T4web\Cron\ConfigFactory;
use T4web\Cron\Log\FileSystem;

class ConfigFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $filesystem = $this->prophesize(FileSystem::class);

        $factory = new ConfigFactory();

        $serviceLocator->get('Config')->willReturn([]);
        $serviceLocator->get(FileSystem::class)->willReturn($filesystem->reveal());

        $filesystem->isWritable(Argument::any())->willReturn(true);

        $config = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($config instanceof Config);
    }
}
