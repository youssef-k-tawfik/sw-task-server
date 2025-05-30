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
    public static function debug(
        string $calling_file,
        int $calling_line,
        mixed $var
    ): void {
        // Only log debug messages in development environment
        $env = $_ENV['APP_ENV'] ?? 'production';
        if ($env !== 'development') {
            return;
        }

        // Substring the file name to start with 'src'
        $src_pos = strpos($calling_file, 'src');
        if ($src_pos !== false) {
            $calling_file = substr($calling_file, $src_pos);
        }

        $caller = $calling_file . ':' . $calling_line ?? 'unknown file';
        error_log("\033[36mCalled from: " . $caller . "\033[0m");

        // transform the variable into a string
        if (is_array($var) || is_object($var)) {
            $var = print_r($var, true);
        }
        error_log("\033[33m" . $var . "\033[0m");
    }
}
