<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\UserOrderStatusEnum;
use App\Events\OrderWasRateEvent;
use App\Models\Dish;
use App\Models\UserOrder;
use Illuminate\Support\Facades\Log;

class RateRestaurantListener
{
    public function __construct()
    {
    }

    public function handle(OrderWasRateEvent $event): void
    {
        $restaurant = $event->getRestaurant();
        $dishesIds = $restaurant->dishes->map(fn (Dish $dish) => $dish->id)->toArray();
        $newRating = UserOrder::whereStatus(UserOrderStatusEnum::COMPLETED)->whereIn('dish_id', array_unique($dishesIds))->avg('rate');
        $restaurant->rating = $newRating;

        try {
            $restaurant->save();

        } catch (\Throwable $exception) {
            Log::error('Error while calculate restaurant rating', [
                'exception' => $exception->getMessage(),
                'restaurant' => $restaurant->id,
            ]);
        }

    }
}
