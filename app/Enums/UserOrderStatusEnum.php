<?php

namespace App\Enums;

enum UserOrderStatusEnum: string
{
    case NEW = 'new'; // создан
    case AWAITING_PAYMENT = 'awaiting_payment'; //ожидает оплаты
    case CREATING = 'creating'; // готовим
    case PACKING = 'packing'; // упаковываем
    case DELIVERING = 'delivering';// доставляем
    case CANCELED = 'canceled'; // отменен
    case COMPLETED = 'completed'; // доставлен
}
