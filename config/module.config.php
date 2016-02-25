<?php

use Zend\Mvc\Router\RouteMatch;

return [

    'service_manager' => require_once 'service_manager.config.php',
    'controllers' => require_once 'controllers.config.php',
    'router' => require_once 'router.config.php',
    'console' => require_once 'console.config.php',

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
