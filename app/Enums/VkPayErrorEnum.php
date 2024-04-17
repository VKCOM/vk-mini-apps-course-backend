<?php

namespace App\Enums;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Коды ошибок vk pay
 */
enum VkPayErrorEnum: string
{
    case ERR_SYSTEM = 'ERR_SYSTEM';
    case ERR_ARGUMENTS = 'ERR_ARGUMENTS';
    case ERR_SIGNATURE = 'ERR_SIGNATURE';
    case ERR_DUPLICATE = 'ERR_DUPLICATE';
}
