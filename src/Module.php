<?php

namespace T4web\Cron;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ControllerProviderInterface
{
    public function getConfig($env = null)
    {
        return include dirname(__DIR__) . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => dirname(__DIR__) . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [

            ]
        ];
    }
}
