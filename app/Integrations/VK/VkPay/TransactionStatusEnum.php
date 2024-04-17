<?php

namespace App\Integrations\VK\VkPay;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Статусы транзакций при оплате через vk pay
 */
enum TransactionStatusEnum: string
{
    case SUCCESS = 'success';
    case FAIL = 'fail';
}
