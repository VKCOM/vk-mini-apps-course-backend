<?php

namespace App\Components\Donate;

use App\Dto\Donate;
use App\Dto\DonateOrderInfo;
use App\Dto\DonateOrderResult;
use App\Models\DonateOrder;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Абстрактный класс процессинга платежного уведомления
 */
abstract class AbstractDonateProcessor
{
    protected const DEFAULT_EXPIRATION = 0;

    abstract public function create(Donate $donate): DonateOrderInfo;

    abstract public function changeStatus(Donate $donate): DonateOrderResult;

    protected function getOrder(Donate $donate): DonateOrder
    {
        return DonateOrder::whereExternalOrderId($donate->getOrderId())->firstOrFail();
    }
}
