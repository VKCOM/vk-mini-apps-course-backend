<?php

declare(strict_types=1);

namespace App\Components\VkPay;

use App\Dto\VkPayOrder;
use App\Dto\VkPayTransaction;
use App\Enums\VkPayCallbackStatusEnum;
use App\Enums\VkPayTransactionStatusEnum;
use App\Integrations\VK\VkPay\ApiClient;
use App\Integrations\VK\VkPay\TransactionActionEnum;
use App\Models\UserOrder;
use App\Models\VkPayTransaction as VkPayOrderTransaction;
use App\Services\UserOrderService;
use Carbon\Carbon;
use Psy\Util\Json;

final class VkPayService
{
    public function __construct(
        private readonly string $merhcantPrivateKey,
        private readonly string $appPrivateKey,
        private readonly ApiClient $apiClient,
        private readonly UserOrderService $userOrderService,
    ) {
    }

    public function makeMerchantData(string $orderId, int $ts, float $amount, string $currency): string
    {
        $data = Json::encode([
            'amount' => $amount,
            'order_id' => $orderId,
            'currency' => $currency,
            'ts' => $ts,
        ]);

        return base64_encode($data);
    }

    public function makeMerchantSign(string $merchantData): string
    {
        return sha1("{$merchantData}{$this->merhcantPrivateKey}");
    }

    public function makeSign(array $data): string
    {
        ksort($data);
        $result = '';
        foreach ($data as $key => $item) {
            if (is_array($item)) {
                $result .= $key . '=' .Json::encode($item);
                continue;
            }

            $result .= "{$key}={$item}";
        }

        return md5("{$result}{$this->appPrivateKey}");
    }

    public function refund(UserOrder $userOrder): void
    {
        $now = Carbon::now();

        $endTime = Carbon::today()->setHour(23)->setMinute(0)->setSecond(0);

        try {
            /** @var VkPayOrderTransaction $transaction */
            $transaction = $userOrder
                ->getTransactions()
                ->where('status', '=', VkPayTransactionStatusEnum::SUCCESS)
                ->firstOrFail();
        } catch (\Throwable) {
            return;
        }

        if ($now->lte($endTime) && $transaction->updated_at->isSameDay($now)) {
            $result = $this->apiClient->makeReverse(
                $transaction->transaction_id,
                $transaction->amount,
            );
        } else {
            $result = $this->apiClient->makeRefund(
                $transaction->transaction_id,
                $transaction->amount,
            );
        }

        if ($result->getTransactionAction() === TransactionActionEnum::WAIT) {
            $transaction->status = VkPayTransactionStatusEnum::REFUND_UNCOMPLETED;
        } else {
            $transaction->status = VkPayTransactionStatusEnum::REFUND;
        }

        $transaction->meta = $result->getRawData();

        $transaction->save();
    }

    public function createTransaction(UserOrder $order, VkPayOrder $orderData): void
    {
        $vkPayTransaction = new VkPayOrderTransaction();
        $vkPayTransaction->user_order_id = $order->id;
        $vkPayTransaction->order_uuid = $orderData->getOrderId();
        $vkPayTransaction->amount = $orderData->getAmount();
        $vkPayTransaction->currency = $orderData->getCurrency();
        $vkPayTransaction->status = VkPayTransactionStatusEnum::NEW;
        $vkPayTransaction->meta = [];

        $vkPayTransaction->save();
    }

    public function transferTransactionToSuccess(VkPayOrderTransaction $vkPayTransaction, VkPayTransaction $transactionData): void
    {
        $vkPayTransaction->status = VkPayTransactionStatusEnum::SUCCESS;
        $vkPayTransaction->transaction_id = $transactionData->getTransactionId();
        $vkPayTransaction->meta = $transactionData->getRawData();

        $order = $vkPayTransaction->userOrder;

        $this->userOrderService->transferToCreating($order);

        $vkPayTransaction->save();
    }

    public function processTransactionCallback(VkPayTransaction $vkPayTransaction): void
    {
        if ($vkPayTransaction->getStatus() !== VkPayCallbackStatusEnum::PAID) {
            return;
        }

        $transaction = VkPayOrderTransaction::whereOrderUuid($vkPayTransaction->getTransactionUuid())->firstOrFail();

        $this->transferTransactionToSuccess($transaction, $vkPayTransaction);
    }
}
