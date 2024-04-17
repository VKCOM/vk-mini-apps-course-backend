<?php
declare(strict_types=1);

namespace App\Events;

use App\Models\Restaurant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Модуль 4. Разработка, Урок 9. Уведомления #M4L13
 * Event об оценке ресторана
 */
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
