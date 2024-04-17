<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Factory\DonateResponseFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\DonateRequest;
use App\Http\Resources\Donate\DonateProductResourceCollection;
use App\Models\DonateItem;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Контроллер с api методами для обработки платежных уведомлений при плате голосами
 */
class DonateController extends Controller
{
    public function handle(DonateRequest $request, DonateResponseFactory $donateResponseFactory): JsonResource
    {
        $result = $donateResponseFactory->create($request);
        $result::wrap('response');

        return $result;
    }

    public function getProducts(): JsonResource
    {
        return new DonateProductResourceCollection(DonateItem::all());
    }
}
