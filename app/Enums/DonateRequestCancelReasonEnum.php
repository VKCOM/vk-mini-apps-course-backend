<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Причины отмены оплаты голосами
 */
enum DonateRequestCancelReasonEnum: string
{
    case USER_DECISION = 'user_decision';
    case APP_DECISION = 'app_decision';
    case PAYMENT_FAIL = 'payment_fail';
    case UNKNOWN = 'unknown';
}
