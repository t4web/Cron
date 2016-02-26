<?php

namespace T4web\CronTest\Log;

use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\Cron\Log\TextFile;
use T4web\Cron\Log\TextFileFactory;

class TextFileFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $factory = new TextFileFactory();

        $config = ['cron' => ['log-directory' => '.']];

        $serviceLocator->get('Config')->willReturn($config);

        $log = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($log instanceof TextFile);
    }
}
