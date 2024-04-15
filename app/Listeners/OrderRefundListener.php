<?php

namespace App\Listeners;

use App\Events\OrderCanceled;

class OrderRefundListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCanceled $event): void
    {
        //
    }
}
