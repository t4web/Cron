<?php

use Zend\Mvc\Router\RouteMatch;

return array(

    'service_manager' => require_once 'service_manager.config.php',
    'controllers' => require_once 'controllers.config.php',
    'router' => require_once 'router.config.php',

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
