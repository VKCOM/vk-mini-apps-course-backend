<?php

namespace App\Integrations\VK\VkPay;

enum TransactionStatusEnum: string
{
    case SUCCESS = 'success';
    case FAIL = 'fail';
}
