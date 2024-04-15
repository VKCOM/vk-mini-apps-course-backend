<?php

namespace App\Enums;

enum VkPayTransactionStatusEnum: string
{
    case NEW = 'new';
    case REFUND = 'refund';
    case REFUND_UNCOMPLETED = 'refund_uncompleted';
    case SUCCESS = 'success';
}
