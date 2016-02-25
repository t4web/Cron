<?php

namespace T4web\Cron\Log;

interface LoggerInterface
{
    /**
     * @param string $jobId
     * @param int $startTime
     * @param int $endTime
     * @param bool $isSuccessful
     * @param array $output
     * @param array $error
     */
    public function log($jobId, $startTime, $endTime, $isSuccessful, $output, $error);
}
