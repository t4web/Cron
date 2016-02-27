<?php

namespace T4web\CronTest;

use T4web\Cron\Config;
use T4web\Cron\Log\FileSystem;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildFromConfig()
    {
        $rawConfig = [
            'log-directory' => 'data', // default: getcwd()/data
            'phpPath'    => 'php', // default: php
            'scriptPath' => '/path/to/application/public/folder/', // default: getcwd()/public/
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
            'timeout' => 3600 // default: null (without timeout)
        ];

        $filesystem = $this->prophesize(FileSystem::class);
        $filesystem->isWritable($rawConfig['log-directory'])->willReturn(true);

        $config = new Config($rawConfig, $filesystem->reveal());

        $this->assertEquals($rawConfig['log-directory'], $config->getLogDirectory());
        $this->assertEquals($rawConfig['phpPath'], $config->getPhpPath());
        $this->assertEquals($rawConfig['scriptPath'], $config->getScriptPath());
        $this->assertEquals($rawConfig['jobs'], $config->getJobs());
        $this->assertEquals($rawConfig['timeout'], $config->getTimeout());
    }

    public function testBuildDefaultConfig()
    {
        $rawConfig = [
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
        ];

        $defaultlogDirectory = getcwd() . '/data';

        $filesystem = $this->prophesize(FileSystem::class);
        $filesystem->isWritable($defaultlogDirectory)->willReturn(true);

        $config = new Config($rawConfig, $filesystem->reveal());

        $this->assertEquals($defaultlogDirectory, $config->getLogDirectory());
        $this->assertEquals('php', $config->getPhpPath());
        $this->assertEquals(getcwd() . '/public/', $config->getScriptPath());
        $this->assertEquals($rawConfig['jobs'], $config->getJobs());
        $this->assertNull($config->getTimeout());
    }
}
