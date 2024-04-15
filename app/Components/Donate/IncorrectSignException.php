<?php

declare(strict_types=1);

namespace App\Components\Donate;

use Throwable;

class IncorrectSignException extends \Exception
{
    public function __construct(string $message = 'Incorrect sign', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
