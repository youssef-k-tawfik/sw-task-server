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
        error_log("\033[32m" . $message . "\033[0m");
    }

    /**
     * Logs variables in yellow color for debugging purposes
     */
    public static function debug(mixed $var): void
    {
        // Only log debug messages in development environment
        if ($_ENV['APP_ENV'] !== 'development') {
            return;
        }

        if (is_array($var) || is_object($var)) {
            $var = print_r($var, true);
        }
        error_log("\033[33m" . $var . "\033[0m");
    }
}
