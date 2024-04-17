<?php

namespace App\Enums;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Статус ответа для vk pay callback
 */
enum VkPayCallbackStatusEnum: string
{
    case PAID = 'PAID';
    case HOLD = 'HOLD';
}
