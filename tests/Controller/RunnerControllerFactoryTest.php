<?php

namespace T4web\CronTest\Controller;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\ControllerManager;
use T4web\Cron\Controller\RunnerController;
use T4web\Cron\Controller\RunnerControllerFactory;
use T4web\Cron\Service\CronService;

class RunnerControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $controllerManager = $this->prophesize(ControllerManager::class);
        $controllerManager->getServiceLocator()->willReturn($serviceLocator);

        $cronService = $this->prophesize(CronService::class);
        $serviceLocator->get(CronService::class)->willReturn($cronService);

        $factory = new RunnerControllerFactory();

        $controller = $factory->createService($controllerManager->reveal());

        $this->assertTrue($controller instanceof RunnerController);
    }
}
