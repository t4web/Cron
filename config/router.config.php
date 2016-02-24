<?php

namespace T4web\Cron;

return [
    'routes' => array(
        'auth-login' => array(
            'type' => 'Literal',
            'options' => array(
                'route'    => '/login-form',
                'defaults' => array(
                    '__NAMESPACE__' => 'T4web\Authentication\Controller\User',
                    'controller'    => 'IndexController',
                    'action'        => 'login-form',
                ),
            ),
        ),
        'auth-logout' => array(
            'type' => 'Literal',
            'options' => array(
                'route'    => '/logout',
                'defaults' => array(
                    '__NAMESPACE__' => 'T4web\Authentication\Controller\User',
                    'controller'    => 'IndexController',
                    'action'        => 'logout',
                ),
            ),
        ),
    ),
];
