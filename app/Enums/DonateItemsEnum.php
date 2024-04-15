<?php

declare(strict_types=1);

namespace App\Enums;

enum DonateItemsEnum: string
{
    case ONE_TIME_VOTE = 'one_time_vote';
    case SUBSCRIBE_VOTE = 'subscribe_vote';
}
