<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\DeliveryAddress;
use App\Enums\UserOrderStatusEnum;
use App\Events\OrderUpdated;
use App\Models\UserOrder;
use App\Models\VkUser;
use Carbon\Carbon;
use Illuminate\Support\Collection;

final class UserOrderService
{
    private const ADV_ORDER_DISCOUNT = 20;

    public function getActiveOrderByVkUser(VkUser $vkUser): ?UserOrder
    {
        $order = $vkUser
            ->orders()
            ->orderByDesc('id')
            ->one()
            ->first()
        ;

        if ($order === null || in_array($order->status, [UserOrderStatusEnum::CANCELED, UserOrderStatusEnum::COMPLETED], true)) {
            return null;
        }

        return $order;
    }

    public function transferToNextStatus(UserOrder $order): void
    {
        switch ($order->status) {
            case UserOrderStatusEnum::CREATING:
                $this->transferToPacking($order);

                break;
            case UserOrderStatusEnum::PACKING:
                $this->transferToDelivering($order);

                break;
            case UserOrderStatusEnum::DELIVERING:
                $this->transferToCompleted($order);

                break;
        }
    }

    public function transferToCreating(UserOrder $order): void
    {
        $order->status = UserOrderStatusEnum::CREATING;
        $order->delivery_planned_at = Carbon::now()->addMinutes(40);
        $order->save();

        $this->produceEvent($order);
    }

    public function transferToPacking(UserOrder $order): void
    {
        $order->status = UserOrderStatusEnum::PACKING;
        $order->delivery_planned_at = Carbon::now()->addMinutes(30);
        $order->save();

        $this->produceEvent($order);
    }

    public function transferToDelivering(UserOrder $order): void
    {
        $order->status = UserOrderStatusEnum::DELIVERING;
        $order->delivery_planned_at = Carbon::now()->addMinutes(10);
        $order->save();

        $this->produceEvent($order);
    }

    public function transferToCompleted(UserOrder $order): void
    {
        $order->status = UserOrderStatusEnum::COMPLETED;
        $order->delivery_planned_at = Carbon::now();
        $order->save();

        $this->produceEvent($order);
    }

    public function transferToAwaitingPayment(
        UserOrder $order,
        Collection $extraOptions,
        DeliveryAddress $deliveryAddress,
        bool $withAdvDiscount
    ): void {
        $order->extra_options = $extraOptions;
        $order->delivery_address = $deliveryAddress;
        $order->discount = $withAdvDiscount ? self::ADV_ORDER_DISCOUNT : 0;

        $order->delivery_planned_at = Carbon::now()->addHours(1);
        $order->delivery_price = 0;
        $order->status = UserOrderStatusEnum::AWAITING_PAYMENT;

        if ($order->save()) {
            $this->produceEvent($order);
        }
    }


    private function produceEvent(UserOrder $order): void
    {
        event(new OrderUpdated($order));
    }
}
