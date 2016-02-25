<?php

namespace T4web\Cron;

return [
    'router' => [
        'routes' => [
            'cron-run' => [
                'type' => 'Simple',
                'options' => [
                    'route' => 'cron run',
                    'defaults' => [
                        'controller' => Controller\RunnerController::class,
                    ],
                ],
            ],
        ],
    ],
];
