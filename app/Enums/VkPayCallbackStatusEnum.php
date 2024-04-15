<?php

namespace App\Enums;

enum VkPayCallbackStatusEnum: string
{
    case PAID = 'PAID';
    case HOLD = 'HOLD';
}
