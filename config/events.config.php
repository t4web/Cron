<?php

namespace T4web\Cron;

return [
    Executor\Executor::class => [
        JobEndedEvent::EVENT_JOB_ENDED => [
            Listener\SaveReport::class,
        ]
    ],
];
