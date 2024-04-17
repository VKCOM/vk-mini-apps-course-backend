<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Components\VkPay\VkPayService;
use App\Events\OrderCanceled;
use Illuminate\Support\Facades\Log;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Обработчик события возврата средств при оплате заказа
 */
class ReturnMoneyListener
{
    public function __construct(private readonly VkPayService $vkPayService)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCanceled $event): void
    {
        try {
            $this->vkPayService->refund($event->getOrder());
        } catch (\Throwable $exception) {
            Log::error('Error during refund money', [
                'exception' => $exception,
            ]);
        }
    }
}
