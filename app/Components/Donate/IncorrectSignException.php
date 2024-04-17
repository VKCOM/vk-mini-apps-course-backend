<?php

declare(strict_types=1);

namespace App\Components\Donate;

use Throwable;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Ошибка проверки подписи платежного уведомления
 */
class IncorrectSignException extends \Exception
{
    public function __construct(string $message = 'Incorrect sign', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
