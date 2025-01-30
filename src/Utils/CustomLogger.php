<?php

declare(strict_types=1);

namespace App\Utils;

class CustomLogger
{
    /**
     * Logs the info message in green color
     */
    public static function logInfo(string $message): void
    {
        echo "\n\033[32m\n" . $message . "\n\033[0m\n";
    }

    /**
     * Logs the error message in red color
     */
    public static function logError(string $message): void
    {
        echo "\n\033[31m\n" . $message . "\n\033[0m\n";
    }
}
