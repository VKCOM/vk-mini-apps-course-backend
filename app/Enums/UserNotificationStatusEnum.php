<?php

namespace App\Enums;

enum UserNotificationStatusEnum: string
{
    case SUCCESS = 'success';
    case FAILED = 'failed';
    case NONE = '';
}
