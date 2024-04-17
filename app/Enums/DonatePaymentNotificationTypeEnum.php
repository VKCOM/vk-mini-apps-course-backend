<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Типы платежных уведомлений
 */
enum DonatePaymentNotificationTypeEnum: string
{
    case GET_ITEM_TEST = 'get_item_test';
    case GET_ITEM = 'get_item';
    case GET_SUBSCRIPTION = 'get_subscription';
    case GET_SUBSCRIPTION_TEST = 'get_subscription_test';
    case ORDER_STATUS_CHANGE_TEST = 'order_status_change_test';
    case ORDER_STATUS_CHANGE = 'order_status_change';
    case ORDER_SUBSCRIPTION_CHANGE = 'subscription_status_change';
    case ORDER_SUBSCRIPTION_CHANGE_TEST = 'subscription_status_change_test';
}
