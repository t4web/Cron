<?php

namespace T4web\CronTest\Controller;

use RuntimeException;
use Zend\Mvc\MvcEvent;
use Zend\Console\Request as ConsoleRequest;
use T4web\Cron\Service\CronService;
use T4web\Cron\Controller\RunnerController;

class RunnerControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RunnerController
     */
    private $controller;

    private $cronService;

    public function setUp()
    {
        $this->cronService = $this->prophesize(CronService::class);

        $this->controller = new RunnerController(
            $this->cronService->reveal()
        );
    }

    public function testOnDispatchWithHttpRequest()
    {
        $event = $this->prophesize(MvcEvent::class);

        $this->cronService->run()->willReturn(null);

        $this->setExpectedException(RuntimeException::class);

        $this->controller->onDispatch($event->reveal());
    }

    public function testOnDispatchWithConsoleRequest()
    {
        $event = $this->prophesize(MvcEvent::class);

        $event->getRequest()->willReturn($this->prophesize(ConsoleRequest::class)->reveal());
        $this->cronService->run()->willReturn(null);


        $this->controller->onDispatch($event->reveal());
    }
}
