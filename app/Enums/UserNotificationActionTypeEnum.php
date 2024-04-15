<?php

namespace App\Enums;

enum UserNotificationActionTypeEnum: string
{
    case SHARE = 'share';
    case LINK = 'link';
    case ORDER = 'order';
}
