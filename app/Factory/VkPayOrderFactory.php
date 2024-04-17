<?php

declare(strict_types=1);

namespace App\Factory;

use App\Components\VkPay\VkPayService;
use App\Dto\VkPayOrder;
use App\Models\UserOrder;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Фабрика для создания оплат заказов через vk pay
 */
final class VkPayOrderFactory
{
    private const DEFAULT_CURRENCY = 'RUB';
    private const DEFAULT_VERSION = 2;

    public function __construct(private readonly VkPayService $vkPayService, private readonly int $merchantId)
    {
    }

    public function create(UserOrder $userOrder): VkPayOrder
    {
        $ts = Carbon::now()->timestamp;
        $orderId = Uuid::uuid4()->toString();
        $merchantData = $this->vkPayService->makeMerchantData(
            orderId: $orderId,
            ts: $ts,
            amount: $userOrder->total_price,
            currency: self::DEFAULT_CURRENCY,
        );

        $description = sprintf('Оплата заказа #%d', $userOrder->id);
        $merchantSign = $this->vkPayService->makeMerchantSign($merchantData);

        $sign = $this->vkPayService->makeSign(
            [
                'amount' => $userOrder->total_price,
                'data' => [
                    'currency' => self::DEFAULT_CURRENCY,
                    'merchant_data' => $merchantData,
                    'merchant_sign' => $merchantSign,
                    'order_id' => $orderId,
                    'ts' => $ts,
                ],
                'description' => $description,
                'merchant_id' => $this->merchantId,
                'version' => self::DEFAULT_VERSION,
            ]
        );

        return new VkPayOrder(
            amount: $userOrder->total_price,
            currency: self::DEFAULT_CURRENCY,
            merchantData: $merchantData,
            merchantSigne: $merchantSign,
            ts: $ts,
            description: $description,
            merchantId: $this->merchantId,
            version: self::DEFAULT_VERSION,
            sign: $sign,
            orderId: $orderId,
        );
    }
}
