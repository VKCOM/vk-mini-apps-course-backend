<?php

declare(strict_types=1);

namespace App\Enums;

enum DonateRequestStatusEnum: string
{
    case CHARGEABLE = 'chargeable';
    case REFUNDED = 'refunded';
    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';
}
