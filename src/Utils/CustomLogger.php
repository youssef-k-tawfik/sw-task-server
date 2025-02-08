<?php

declare(strict_types=1);

namespace App\Utils;

/**
 * Custom logger class to log messages with colors in terminal while developing
 */
class CustomLogger
{
    /**
     * Logs the info message in green color
     */
    public static function logInfo(string $message): void
    {
        echo "\033[32m\n" . $message . "\n\033[0m";
    }

    /**
     * Logs the error message in red color
     */
    public static function logError(string $message): void
    {
        echo "\033[31m\n" . $message . "\n\033[0m";
    }
}
