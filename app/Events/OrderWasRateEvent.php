<?php
declare(strict_types=1);

namespace App\Events;

use App\Models\Restaurant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderWasRateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(private Restaurant $restaurant)
    {
    }

    public function getRestaurant(): Restaurant
    {
        return $this->restaurant;
    }
}
