<?php

declare(strict_types=1);

namespace App\Components\Donate;

use App\Dto\Donate;
use App\Dto\DonateOrderInfo;
use App\Dto\DonateOrderResult;
use App\Enums\DonateItemsEnum;
use App\Enums\DonateRequestCancelReasonEnum;
use App\Enums\DonateRequestStatusEnum;
use App\Models\DonateItem;
use App\Models\DonateOrder;
use DateTimeImmutable;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Обработка подписочной оплаты голосами
 */
final class DonateSubscriptionPayment extends AbstractDonateProcessor
{
    public function create(Donate $donate): DonateOrderInfo
    {
        $donateItem = $this->getItem();

        $donateOrder = new DonateOrder();
        $donateOrder->donate_item_id = $donateItem->id;
        $donateOrder->external_order_id = $donate->getOrderId();
        $donateOrder->vk_user_id = $donate->getUserId();
        $donateOrder->price = $donateItem->price;
        $donateOrder->active_to = (new DateTimeImmutable())->modify(sprintf('+ %d days', $donateItem->period));
        $donateOrder->type = 'new';
        $donateOrder->status = 'new';
        $donateOrder->meta = get_object_vars($donate);
        $donateOrder->subscription_id = $donate->getSubscriptionId() ?? 0;

        $donateOrder->save();

        return new DonateOrderInfo(
            title: $donateItem->title,
            price: $donateItem->price,
            discount: 0,
            itemId: $donateItem->code,
            expiration: self::DEFAULT_EXPIRATION,
            period: $donateItem->period,
        );
    }

    public function changeStatus(Donate $donate): DonateOrderResult
    {
        $item = $this->getItem();
        $order = DonateOrder::whereVkUserId($donate->getUserId())->whereDonateItemId($item->id)->firstOrFail();

        if ($donate->getStatus() === DonateRequestStatusEnum::ACTIVE || $donate->getStatus() === DonateRequestStatusEnum::CHARGEABLE) {
            if ($donate->getSubscriptionCanselReason() === null || $donate->getSubscriptionCanselReason() === DonateRequestCancelReasonEnum::UNKNOWN) {
                $order->status = 'payed';
                $order->type = 'active';
            } elseif ($donate->getSubscriptionCanselReason() === DonateRequestCancelReasonEnum::USER_DECISION && $order->status === 'payed') {
                $order->status = 'canceled';
            }
        } elseif ($donate->getStatus() === DonateRequestStatusEnum::REFUNDED) {
            $order->status = 'refunded';
            $order->type = 'canceled';
        }

        $order->subscription_id = $donate->getSubscriptionId();
        $order->meta = get_object_vars($donate);

        $order->save();

        return new DonateOrderResult(
            internalOrderId: $order->id,
            externalOrderId: $donate->getSubscriptionId(),
        );
    }

    private function getItem(): DonateItem
    {
        return DonateItem::whereCode(DonateItemsEnum::SUBSCRIBE_VOTE->value)->firstOrFail();
    }
}
