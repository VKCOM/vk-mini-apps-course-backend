<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Типы оплат голосами
 */
enum DonateItemsEnum: string
{
    case ONE_TIME_VOTE = 'one_time_vote';
    case SUBSCRIBE_VOTE = 'subscribe_vote';
}
