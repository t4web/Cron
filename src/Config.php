<?php

namespace T4web\Cron;

use Zend\Stdlib;
use T4web\Cron\Exception\RuntimeException;
use T4web\Cron\Log\FileSystem;

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
     * @var string
     */
    protected $logDirectory;

    /**
     * @var FileSystem
     */
    protected $fileSystem;

    /**
     * Config constructor.
     *
     * @param array           $config
     * @param FileSystem|null $filesystem
     */
    public function __construct(array $config = [], FileSystem $filesystem = null)
    {
        if (!$filesystem) {
            $filesystem = new FileSystem();
        }

        $this->fileSystem = $filesystem;

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

        $logDirectory = null;
        if (isset($config['log-directory']) && !empty($config['log-directory'])) {
            $logDirectory = $config['log-directory'];
        }

        $this->logDirectory = $this->prepareLogDirectory($logDirectory);
    }

    private function prepareLogDirectory($logDirectory)
    {
        if (empty($logDirectory)) {
            $logDirectory = getcwd() . '/data';
        }

        $logDirectory = rtrim($logDirectory, '/');

        if (!$this->fileSystem->isWritable($logDirectory)) {
            throw new RuntimeException("Directory $logDirectory must be writable");
        }

        return $logDirectory;
    }

    /**
     * @return string
     */
    public function getLogDirectory()
    {
        return $this->logDirectory;
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
