<?php

declare(strict_types=1);

namespace App\Enums;

enum DonateRequestCancelReasonEnum: string
{
    case USER_DECISION = 'user_decision';
    case APP_DECISION = 'app_decision';
    case PAYMENT_FAIL = 'payment_fail';
    case UNKNOWN = 'unknown';
}
