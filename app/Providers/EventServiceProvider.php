<?php

namespace App\Providers;

use App\Events\AchievementReached;
use App\Events\NotificationCreated;
use App\Events\NotificationViewed;
use App\Events\OrderCanceled;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use App\Events\OrderWasRateEvent;
use App\Listeners\CreateFirstOrderAchievementListener;
use App\Listeners\CreateNotificationWhenAchievementReachedListener;
use App\Listeners\CreateOrderAchievementListener;
use App\Listeners\CreateOrderCanceledNotificationListener;
use App\Listeners\CreateOrderNotificationListener;
use App\Listeners\IncreaseNotificationCounterListener;
use App\Listeners\RateRestaurantListener;
use App\Listeners\ReturnMoneyListener;
use App\Listeners\SendPushListener;
use App\Listeners\SetToZeroNotificationCounterListener;
use App\Listeners\SkipPaymentListener;
use App\Listeners\UpUserLevelListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NotificationCreated::class => [
            IncreaseNotificationCounterListener::class,
            SendPushListener::class,
        ],
        NotificationViewed::class => [
            SetToZeroNotificationCounterListener::class,
        ],
        OrderUpdated::class => [
            CreateOrderNotificationListener::class,
            CreateFirstOrderAchievementListener::class,
            CreateOrderAchievementListener::class,
            UpUserLevelListener::class,
            SkipPaymentListener::class,
        ],
        OrderCanceled::class => [
            CreateOrderCanceledNotificationListener::class,
            ReturnMoneyListener::class
        ],
        OrderWasRateEvent::class => [
            RateRestaurantListener::class
        ],
        AchievementReached::class => [
            CreateNotificationWhenAchievementReachedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
