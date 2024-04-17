<?php

declare(strict_types=1);

namespace App\Components\Donate;

use App\Dto\Donate;
use App\Dto\DonateOrderInfo;
use App\Dto\DonateOrderResult;
use App\Enums\DonateRequestStatusEnum;
use App\Models\DonateItem;
use App\Models\DonateOrder;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Обработка разовой оплаты голосами
 */
final class DonateSinglePayment extends AbstractDonateProcessor
{
    public function create(Donate $donate): DonateOrderInfo
    {
        $donateItem = DonateItem::whereCode($donate->getItem())->firstOrFail();

        $donateOrder = new DonateOrder();
        $donateOrder->donate_item_id = $donateItem->id;
        $donateOrder->external_order_id = $donate->getOrderId();
        $donateOrder->vk_user_id = $donate->getUserId();
        $donateOrder->price = $donateItem->price;
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
        );
    }

    public function changeStatus(Donate $donate): DonateOrderResult
    {
        $order = $this->getOrder($donate);
        if ($donate->getStatus() === DonateRequestStatusEnum::CHARGEABLE) {
            $order->status = 'payed';
            $order->type = 'active';
        } elseif ($donate->getStatus() === DonateRequestStatusEnum::REFUNDED) {
            $order->status = 'refunded';
            $order->type = 'canceled';
        }

        $order->meta = get_object_vars($donate);

        $order->save();

        return new DonateOrderResult(
            internalOrderId: $order->id,
            externalOrderId: $donate->getOrderId(),
        );
    }
}
