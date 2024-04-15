<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\VkPayTransaction;
use App\Enums\VkPayCallbackStatusEnum;

final class VkPayTransactionResultFactory
{
    public function create(string $encodedData): VkPayTransaction
    {
        $json = json_decode(base64_decode($encodedData), true);

        return new VkPayTransaction(
            transactionId: $json['body']['transaction_id'],
            notificationType: $json['body']['notify_type'],
            amount: (float) $json['body']['amount'],
            status: VkPayCallbackStatusEnum::from($json['body']['status']),
            transactionUuid: $json['body']['merchant_param']['order_id'],
            rawData: $json,
        );
    }
}
