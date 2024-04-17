<?php

namespace App\Integrations\VK\VkPay;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Типы действий транзакций vk pay
 */
enum TransactionActionEnum: string
{
    case WAIT = 'wait';
    case STOP = 'stop';
}
