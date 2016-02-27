<?php

namespace T4web\CronTest\Resolver;

use T4web\Cron\Resolver\ArrayResolver;
use T4web\Cron\Job\ShellJob;
use T4web\Cron\Exception\RuntimeException;

class ArrayResolverTest extends \PHPUnit_Framework_TestCase
{
    private $resolver;

    public function setUp()
    {
        $this->resolver = new ArrayResolver('php', '/proj');
    }

    public function testBuildFromConfig()
    {
        $configJobs = [
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
        ];

        /** @var ShellJob[] $jobs */
        $jobs = $this->resolver->buildFromConfig($configJobs);

        $this->assertCount(2, $jobs);
        $this->assertInstanceOf(ShellJob::class, $jobs[0]);
        $this->assertInstanceOf(ShellJob::class, $jobs[1]);
        $this->assertEquals('cron-job1', $jobs[0]->getId());
        $this->assertEquals('cron-job2', $jobs[1]->getId());
    }

    public function testBuildFromConfigWithBadConfig()
    {
        $configJobs = [
            [
                'schedule' => '* * * * *'
            ]
        ];

        $this->setExpectedException(RuntimeException::class);

        $this->resolver->buildFromConfig($configJobs);
    }

    public function testResolve()
    {
        $configJobs = [
            [
                'id' => 'cron-job1',
                'command'  => 'index.php application cron-job1',
                'schedule' => '1 0 * * 0'
            ],
            [
                'id' => 'cron-job2',
                'command'  => 'index.php application cron-job2',
                'schedule' => '* * * * *'
            ]
        ];

        /** @var ShellJob[] $jobs */
        $this->resolver->buildFromConfig($configJobs);

        $jobs = $this->resolver->resolve($configJobs);

        $this->assertCount(1, $jobs);
        $this->assertInstanceOf(ShellJob::class, $jobs[0]);
        $this->assertEquals('cron-job2', $jobs[0]->getId());
    }
}
