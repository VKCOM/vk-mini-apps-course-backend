<?php

namespace App\Listeners;

use App\Enums\UserOrderStatusEnum;
use App\Events\OrderUpdated;
use App\Services\UserOrderService;

class SkipPaymentListener
{
    public function __construct(private readonly UserOrderService $userOrderService)
    {
    }

    public function handle(OrderUpdated $event): void
    {
        $user = $event->getOrder()->user;

        if ($user->is_vk_pay_enabled || $event->getOrder()->status !== UserOrderStatusEnum::AWAITING_PAYMENT) {
            return;
        }

        $this->userOrderService->transferToCreating($event->getOrder());
    }
}
