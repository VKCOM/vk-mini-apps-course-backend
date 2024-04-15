<?php

namespace App\Listeners;

use App\Enums\UserOrderStatusEnum;
use App\Events\OrderUpdated;

class UpUserLevelListener
{
    public function handle(OrderUpdated $event): void
    {
        $order = $event->getOrder();
        if ($order->status !== UserOrderStatusEnum::COMPLETED) {
            return;
        }

        $user = $order->user;
        $user->lvl += $order->dish->bonus;
        $user->save();
    }
}
