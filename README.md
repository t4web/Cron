# Cron
ZF2 Module. A PHP cron task manager for ZF2 Application. Implementation for [Cron/Cron](https://github.com/Cron/Cron)

## Installation

Installation of Cron Module uses composer.

```sh
php composer.phar require t4web/cron
```

or add to your composer.json
```json
"require": {
  "t4web/cron": "^1.0.0"
}
```

Then add `T4web\Cron` to your `config/application.config.php`

### Configuration

Add to your configuration:

```php
'cron' => [
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
]
```

General options: 

| Option | Description |
|--------|-------------|
| log-directory | __(not required)__ path to the log files, no required, but if empty - directory `data` must be writable |
| phpPath | __(not required)__ path to the php executable, usually "php" |
| scriptPath | __(not required)__ path to your applications public folder, defaults to your root application public folder |
| jobs | an array of jobs and their schedules |
| timeout | __(not required)__ timeout for the cron job (in seconds) |

Options for cron jobs:

| Option | Description |
|--------|-------------|
| id | __(required)__ job identificator - for grouping job reports |
| command | __(required)__ the php script command to be run |
| schedule | __(required)__ A valid [Cron schedule](https://en.wikipedia.org/wiki/Cron) |

#### Run cron job from command line

We recommend add this command to cron with run every minute (* * * * *)

```sh
php index.php cron run
```

### Logs

After run in `log-directory` will be created log file by pattern `JOB-ID.log` (example: data/cron-job1.log) with content like this:
```
[2016-02-25 15:43:48] Job fail
  Start: 2016-02-25 15:43:47
  End: 2016-02-25 15:43:48
  Execution time: 1 seconds
--Output: 
1
2
3

--End output.
--Error: 
PHP Fatal error:  Call to undefined function Application\Controller\asd() in /storage/proj/1season/module/Application/src/Application/Controller/CronController.php on line 21
PHP Stack trace:
PHP   1. {main}() /storage/proj/1season/public/index.php:0
PHP   2. Zend\Mvc\Application->run() /storage/proj/1season/public/index.php:21
PHP   3. Zend\EventManager\EventManager->trigger() /storage/proj/1season/vendor/zendframework/zend-mvc/src/Application.php:314
PHP   4. Zend\EventManager\EventManager->triggerListeners() /storage/proj/1season/vendor/zendframework/zend-eventmanager/src/EventManager.php:214
PHP   5. call_user_func:{/storage/proj/1season/vendor/zendframework/zend-eventmanager/src/EventManager.php:490}() /storage/proj/1season/vendor/zendframework/zend-eventmanager/src/EventManager.php:490
PHP   6. Zend\Mvc\DispatchListener->onDispatch() /storage/proj/1season/vendor/zendframework/zend-eventmanager/src/EventManager.php:490
PHP   7. Zend\Mvc\Controller\AbstractController->dispatch() /storage/proj/1season/vendor/zendframework/zend-mvc/src/DispatchListener.php:93
PHP   8. Zend\EventManager\EventManager->trigger() /storage/proj/1season/vendor/zendframework/zend-mvc/src/Controller/AbstractController.php:118
PHP   9. Zend\EventManager\EventManager->triggerListeners() /storage/proj/1season/vendor/zendframework/zend-eventmanager/src/EventManager.php:214
PHP  10. call_user_func:{/storage/proj/1season/vendor/zendframework/zend-eventmanager/src/EventManager.php:490}() /storage/proj/1season/vendor/zendframework/zend-eventmanager/src/EventManager.php:490
PHP  11. Zend\Mvc\Controller\AbstractActionController->onDispatch() /storage/proj/1season/vendor/zendframework/zend-eventmanager/src/EventManager.php:490
PHP  12. Application\Controller\CronController->job1Action() /storage/proj/1season/vendor/zendframework/zend-mvc/src/Controller/AbstractActionController.php:82

--End error.
```