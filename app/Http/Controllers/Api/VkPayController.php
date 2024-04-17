<?php

namespace App\Http\Controllers\Api;

use App\Components\VkPay\VkPayService;
use App\Factory\VkPayOrderFactory;
use App\Factory\VkPayResponseFactory;
use App\Http\Controllers\Controller;
use App\Http\Resources\VkPayOrderResource;
use App\Models\UserOrder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Контроллер с api методами для обработки платежных уведомлений при плате vk pay
 */
class VkPayController extends Controller
{
    public function getPaymentData(UserOrder $order, VkPayOrderFactory $vkPayOrderFactory, VkPayService $vkPayService): JsonResource
    {
        if ($order->vk_user_id !== Auth::id()) {
            abort(403);
        }

        $orderData = $vkPayOrderFactory->create($order);

        $vkPayService->createTransaction($order, $orderData);

        return new VkPayOrderResource(
            amount: $orderData->getAmount(),
            currency: $orderData->getCurrency(),
            merchantData: $orderData->getMerchantData(),
            merchantSigne: $orderData->getMerchantSigne(),
            ts: $orderData->getTs(),
            description: $orderData->getDescription(),
            merchantId: $orderData->getMerchantId(),
            version: $orderData->getVersion(),
            sign: $orderData->getSign(),
            orderId: $orderData->getOrderId(),
        );
    }

    public function handleCallback(FormRequest $request, VkPayResponseFactory $vkPayResponseFactory): JsonResource
    {
        $requestData = $request->toArray();

        return $vkPayResponseFactory->create($requestData['data'], $requestData['signature']);
    }
}
