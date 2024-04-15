<?php

namespace App\Enums;

enum VkPayErrorEnum: string
{
    case ERR_SYSTEM = 'ERR_SYSTEM';
    case ERR_ARGUMENTS = 'ERR_ARGUMENTS';
    case ERR_SIGNATURE = 'ERR_SIGNATURE';
    case ERR_DUPLICATE = 'ERR_DUPLICATE';
}
