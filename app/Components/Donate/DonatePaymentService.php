<?php

declare(strict_types=1);

namespace App\Components\Donate;

use App\Dto\Donate;
use App\Dto\DonateOrderInfo;
use App\Dto\DonateOrderResult;
use App\Enums\DonatePaymentNotificationTypeEnum;
use App\Http\Requests\DonateRequest;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * @see DonatePaymentService::verify  - Проверка подписи платежного уведомления
 * @see DonatePaymentService::process - Обработка платежных уведомлений
 */
final class DonatePaymentService
{
    public function __construct(private readonly DonateSinglePayment $donateOrderPayment, private readonly DonateSubscriptionPayment $donateSubscriptionPayment, private readonly string $appSecretKey)
    {
    }

    /**
     * @throws IncorrectSignException
     */
    public function process(DonateRequest $request): DonateOrderInfo|DonateOrderResult
    {
        $this->verify($request);

        $donate = $this->getDonateParams($request);

        return match ($donate->getNotificationType()) {
            DonatePaymentNotificationTypeEnum::GET_ITEM, DonatePaymentNotificationTypeEnum::GET_ITEM_TEST => $this->donateOrderPayment->create($donate),
            DonatePaymentNotificationTypeEnum::GET_SUBSCRIPTION, DonatePaymentNotificationTypeEnum::GET_SUBSCRIPTION_TEST => $this->donateSubscriptionPayment->create($donate),
            DonatePaymentNotificationTypeEnum::ORDER_STATUS_CHANGE_TEST, DonatePaymentNotificationTypeEnum::ORDER_STATUS_CHANGE => $this->donateOrderPayment->changeStatus($donate),
            DonatePaymentNotificationTypeEnum::ORDER_SUBSCRIPTION_CHANGE, DonatePaymentNotificationTypeEnum::ORDER_SUBSCRIPTION_CHANGE_TEST => $this->donateSubscriptionPayment->changeStatus($donate),
        };
    }

    /**
     * @throws IncorrectSignException
     */
    private function verify(DonateRequest $request): void
    {
        $data = $request->toArray();
        $sig = $request->get('sig');

        ksort($data);
        $str = '';
        foreach ($data as $index => $value) {
            if ($value === $sig) {
                continue;
            }
            $str .= "{$index}={$value}";
        }

        if (md5("{$str}{$this->appSecretKey}") !== (string)$sig) {
            throw new IncorrectSignException();
        }
    }

    private function getDonateParams(DonateRequest $request): Donate
    {
        return new Donate(
            appId: (int)$request->get('app_id'),
            notificationType: $request->get('notification_type'),
            orderId: (int) $request->get('order_id'),
            userId: (int) $request->get('user_id'),
            receiverId: (int) $request->get('receiver_id'),
            item: $request->get('item'),
            status: $request->get('status'),
            itemId: $request->get('item_id'),
            itemTitle: $request->get('item_title'),
            itemPrice: $request->get('item_price'),
            subscriptionId: (int) $request->get('subscription_id'),
            subscriptionCanselReason: $request->get('cancel_reason')
        );
    }
}
