<?php

namespace T4web\Cron;

use Zend\Stdlib;

class Config
{
    /**
     * Array of shell jobs.
     *
     * @var array
     */
    protected $jobs = [];

    /**
     * PHP executable path for using shell jobs. Defaults 'php'.
     *
     * @var string
     */
    protected $phpPath = 'php';

    /**
     * Base path for script. Defaults 'getcwd()/public/'.
     *
     * @var string
     */
    protected $scriptPath = null;

    /**
     * Timeout in seconds for the process. null for no timeout.
     *
     * @var int
     */
    protected $timeout = null;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (isset($config['phpPath']) && !empty($config['phpPath'])) {
            $this->phpPath = $config['phpPath'];
        }

        if (isset($config['scriptPath']) && !empty($config['scriptPath'])) {
            $this->scriptPath = $config['scriptPath'];
        }

        if (isset($config['jobs']) && !empty($config['jobs']) && is_array($config['jobs'])) {
            $this->jobs = $config['jobs'];
        }

        if (isset($config['timeout']) && !empty($config['timeout'])) {
            $this->timeout = $config['timeout'];
        }
    }

    /**
     * @return array
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * @param $key
     * @return array
     */
    public function getJob($key)
    {
        return $this->jobs[$key];
    }

    /**
     * @return boolean
     */
    public function hasJobs()
    {
        return (bool) (count($this->jobs) > 0);
    }

    /**
     * @return string
     */
    public function getPhpPath()
    {
        return $this->phpPath;
    }

    /**
     * @return string
     */
    public function getScriptPath()
    {
        if (!$this->scriptPath) {
            $this->scriptPath = getcwd() . DIRECTORY_SEPARATOR  . 'public' . DIRECTORY_SEPARATOR;
        }
        return $this->scriptPath;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
}
