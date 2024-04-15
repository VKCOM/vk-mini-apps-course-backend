<?php

namespace App\Console\Commands;

use App\Enums\VkPayTransactionStatusEnum;
use App\Integrations\VK\VkPay\ApiClient;
use App\Integrations\VK\VkPay\TransactionActionEnum;
use App\Models\VkPayTransaction;
use Illuminate\Console\Command;

class CheckVkPayReverseOperation extends Command
{
    protected $signature = 'app:check-vk-pay-reverse-operation';

    protected $description = 'Command description';

    public function __construct(private readonly ApiClient $apiClient)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $transactions = VkPayTransaction::whereStatus(VkPayTransactionStatusEnum::REFUND_UNCOMPLETED)->get();
        foreach ($transactions as $transaction) {
            try {
                $result = $this->apiClient->pullStatus(transactionId: $transaction->transaction_id);
            } catch (\Throwable) {
                continue;
            }

            if ($result->getTransactionAction() === TransactionActionEnum::STOP) {
                $transaction->status = VkPayTransactionStatusEnum::REFUND;
                $transaction->save();
            }
        }

        return Command::SUCCESS;
    }
}
