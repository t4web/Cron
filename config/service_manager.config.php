<?php

namespace T4web\Cron;

return [
    'factories' => [
        Service\CronService::class => Service\CronServiceFactory::class,

        Listener\SaveReport::class => Listener\SaveReportFactory::class,

        Log\LoggerInterface::class => Log\TextFileFactory::class,
    ],
];
