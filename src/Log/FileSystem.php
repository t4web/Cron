<?php

namespace T4web\Cron\Log;

class FileSystem
{
    /**
     * @param string $filename
     * @return bool
     */
    public function isWritable($filename)
    {
        return is_writable($filename);
    }

    /**
     * @param string $filename
     * @param string $message
     * @return int
     */
    public function put($filename, $message)
    {
        return file_put_contents($filename, $message, FILE_APPEND);
    }
}
