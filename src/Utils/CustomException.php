<?php

declare(strict_types=1);

namespace App\Utils;

use Exception;

class CustomException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // logging the exception in a red color for better visibility in terminal
        $message = "\n\033[31m\n" . $message . "\n\033[0m\n";

        parent::__construct($message, $code, $previous);
    }
}
