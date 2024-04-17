<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enums\DonateRequestCancelReasonEnum;
use App\Enums\DonateRequestStatusEnum;
use App\Enums\DonatePaymentNotificationTypeEnum;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Data Transfer Object: оплата от пользователя и ее статус
 */
final class Donate
{
    private readonly DonatePaymentNotificationTypeEnum $notificationType;
    private readonly ?DonateRequestStatusEnum $status;
    private readonly ?DonateRequestCancelReasonEnum $subscriptionCanselReason;

    public function __construct(
        private readonly int     $appId,
        string  $notificationType,
        private readonly int     $orderId,
        private readonly int     $userId,
        private readonly int     $receiverId,
        private readonly ?string $item = null,
        ?string $status = null,
        private readonly ?string $itemId = null,
        private readonly ?string $itemTitle = null,
        private readonly ?string $itemPrice = null,
        private readonly ?int $subscriptionId = null,
        ?string $subscriptionCanselReason = null,
    ) {
        $this->notificationType = DonatePaymentNotificationTypeEnum::from($notificationType);
        $this->status = $status !== null && $status !== '' && $status !== '0'
            ? DonateRequestStatusEnum::from($status)
            : null
        ;
        $this->subscriptionCanselReason = $subscriptionCanselReason !== null && $subscriptionCanselReason !== '' && $subscriptionCanselReason !== '0'
            ? DonateRequestCancelReasonEnum::from($subscriptionCanselReason)
            : null
        ;
    }

    public function getAppId(): int
    {
        return $this->appId;
    }

    public function getItem(): ?string
    {
        return $this->item;
    }

    public function getNotificationType(): DonatePaymentNotificationTypeEnum
    {
        return $this->notificationType;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getReceiverId(): int
    {
        return $this->receiverId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getStatus(): ?DonateRequestStatusEnum
    {
        return $this->status;
    }

    public function getItemId(): ?string
    {
        return $this->itemId;
    }

    public function getItemTitle(): ?string
    {
        return $this->itemTitle;
    }

    public function getItemPrice(): ?string
    {
        return $this->itemPrice;
    }

    public function getSubscriptionId(): ?int
    {
        return $this->subscriptionId;
    }

    public function getSubscriptionCanselReason(): ?DonateRequestCancelReasonEnum
    {
        return $this->subscriptionCanselReason;
    }
}
