<?php

namespace T4web\CronTest\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\Cron\Service\CronService;
use T4web\Cron\Service\CronServiceFactory;

class CronServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $factory = new CronServiceFactory();

        $config = [
            'cron' => [
                'jobs'       => [
                    [
                        'id' => 'cron-job1',
                        'command'  => 'index.php application cron-job1',
                        'schedule' => '* * * * *'
                    ],
                    [
                        'id' => 'cron-job2',
                        'command'  => 'index.php application cron-job2',
                        'schedule' => '* * * * *'
                    ]
                ],
            ]
        ];

        $serviceLocator->get('Config')->willReturn($config);

        $log = $factory->createService($serviceLocator->reveal());

        $this->assertTrue($log instanceof CronService);
    }
}
