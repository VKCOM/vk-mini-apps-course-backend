<?php

declare(strict_types=1);

namespace App\Factory;

use App\Components\VkPay\SignatureService;
use App\Components\VkPay\VkPayService;
use App\Enums\VkPayErrorEnum;
use App\Enums\VkPayTransactionStatusEnum;
use App\Http\Resources\VkPayErrorResponseResource;
use App\Http\Resources\VkPayResponseResource;
use App\Models\VkPayTransaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Фабрика для создания json ответов для vk pay
 */
final class VkPayResponseFactory
{
    public function __construct(
        private readonly VkPayService $vkPayService,
        private readonly SignatureService $signatureService,
        private readonly VkPayTransactionResultFactory $transactionResultFactory,
        private readonly int $merchantId
    ) {
    }

    public function create(string $data, string $signature): JsonResource
    {
        $transactionDto = $this->transactionResultFactory->create($data);

        if (!$this->signatureService->validateSignature($data, $signature)) {
            return new VkPayErrorResponseResource(
                transactionId: $transactionDto->getTransactionId(),
                notificationType: $transactionDto->getNotificationType(),
                merchanId: $this->merchantId,
                errorCode: VkPayErrorEnum::ERR_SIGNATURE
            );
        }

        try {
            $vkPayTransaction = VkPayTransaction::whereOrderUuid($transactionDto->getTransactionUuid())->firstOrFail();
        } catch (ModelNotFoundException) {
            return new VkPayErrorResponseResource(
                transactionId: $transactionDto->getTransactionId(),
                notificationType: $transactionDto->getNotificationType(),
                merchanId: $this->merchantId,
                errorCode: VkPayErrorEnum::ERR_ARGUMENTS,
                errorMessage: 'Транзакция не найдена',
            );
        }

        if ($vkPayTransaction->status !== VkPayTransactionStatusEnum::NEW) {
            return new VkPayErrorResponseResource(
                transactionId: $transactionDto->getTransactionId(),
                notificationType: $transactionDto->getNotificationType(),
                merchanId: $this->merchantId,
                errorCode: VkPayErrorEnum::ERR_DUPLICATE,
                errorMessage: 'Транзакция уже была обработана',
            );
        }

        $this->vkPayService->processTransactionCallback($transactionDto);

        return new VkPayResponseResource(
            transactionId: $transactionDto->getTransactionId(),
            notificationType: $transactionDto->getNotificationType(),
            merchanId: $this->merchantId
        );
    }
}
