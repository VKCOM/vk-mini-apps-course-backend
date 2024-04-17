<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Статусы оплаты голосами для ответа в API VK
 */
enum DonateRequestStatusEnum: string
{
    case CHARGEABLE = 'chargeable';
    case REFUNDED = 'refunded';
    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';
}
