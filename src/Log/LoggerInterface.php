<?php

namespace T4web\Cron\Log;

interface LoggerInterface
{
    public function log($jobId, $startTime, $endTime, $isSuccessful, $output, $error);
}
