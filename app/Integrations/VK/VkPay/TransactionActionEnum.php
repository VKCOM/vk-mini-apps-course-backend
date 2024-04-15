<?php

namespace App\Integrations\VK\VkPay;

enum TransactionActionEnum: string
{
    case WAIT = 'wait';
    case STOP = 'stop';
}
