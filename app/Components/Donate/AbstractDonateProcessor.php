<?php

namespace App\Components\Donate;

use App\Dto\Donate;
use App\Dto\DonateOrderInfo;
use App\Dto\DonateOrderResult;
use App\Models\DonateOrder;

abstract class AbstractDonateProcessor
{
    protected const DEFAULT_EXPIRATION = 3600;

    abstract public function create(Donate $donate): DonateOrderInfo;

    abstract public function changeStatus(Donate $donate): DonateOrderResult;

    protected function getOrder(Donate $donate): DonateOrder
    {
        return DonateOrder::whereExternalOrderId($donate->getOrderId())->firstOrFail();
    }
}
