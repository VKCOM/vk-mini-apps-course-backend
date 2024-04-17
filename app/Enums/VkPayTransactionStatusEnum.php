<?php

namespace App\Enums;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Статус транзакций в vk pay
 */
enum VkPayTransactionStatusEnum: string
{
    case NEW = 'new';
    case REFUND = 'refund';
    case REFUND_UNCOMPLETED = 'refund_uncompleted';
    case SUCCESS = 'success';
}
