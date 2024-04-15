<?php

namespace App\Events;

use App\Models\UserOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCanceled
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(private UserOrder $order)
    {
    }

    public function getOrder(): UserOrder
    {
        return $this->order;
    }
}
