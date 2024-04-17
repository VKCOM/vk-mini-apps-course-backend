<?php

namespace App\Providers;

use App\Components\Donate\DonatePaymentService;
use App\Components\Donate\DonateSinglePayment;
use App\Components\Donate\DonateSubscriptionPayment;
use App\Components\VkPay\SignatureService;
use App\Components\VkPay\VkPayService;
use App\Factory\VkPayOrderFactory;
use App\Factory\VkPayResponseFactory;
use App\Factory\VkPayTransactionResultFactory;
use App\Integrations\VK\Counter\ApiClient as CounterApiClient;
use App\Integrations\VK\Push\ApiClient as PushApiClient;
use App\Integrations\VK\VkPay\ApiClient as VkPayApiClient;
use App\Services\UserOrderService;
use App\Services\VkLaunchParamsService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * Модуль 4. Разработка, Урок 9. Авторизация запросов к серверу мини-приложения #M4L9
         * Передача идентификатора мини-приложения и секретного ключа из конфигурации в сервис авторизации VkLaunchParamsService.
         */
        $this->app->bind(VkLaunchParamsService::class, fn(): \App\Services\VkLaunchParamsService => new VkLaunchParamsService(
            appId: (int) Config::get('vk.app_id'),
            appSecret: (string) Config::get('vk.app_secret'),
        ));

        $this->app->bind(DonatePaymentService::class, fn(Application $app): \App\Components\Donate\DonatePaymentService => new DonatePaymentService(
            donateOrderPayment: $app->make(DonateSinglePayment::class),
            donateSubscriptionPayment: $app->make(DonateSubscriptionPayment::class),
            appSecretKey: (string) Config::get('vk.app_secret'),
        ));

        $this->app->bind(PushApiClient::class, fn(): \App\Integrations\VK\Push\ApiClient => new PushApiClient(
            baseUrl: (string) Config::get('vk.default_api_url'),
            accessToken: (string) Config::get('vk.service_key'),
            appId: (int) Config::get('vk.app_id'),
        ));

        /**
         * Модуль 4. Разработка, Урок 18. Счётчики и бейджи #M4L18
         * Передача в CounterApiClient сервисного токена и настроек для работы с API VK
         */
        $this->app->bind(CounterApiClient::class, fn(): \App\Integrations\VK\Counter\ApiClient => new CounterApiClient(
            defaultUrl: (string) Config::get('vk.default_api_url'),
            accessToken: (string) Config::get('vk.service_key'),
        ));

        $this->app->bind(SignatureService::class, fn(): \App\Components\VkPay\SignatureService => new SignatureService(
            signatureKey: (string) Config::get('vk_pay.merchant_signature_key'),
            merchanKey: (string) Config::get('vk_pay.merchant_key'),
        ));

        $this->app->bind(VkPayApiClient::class, fn(Application $app): \App\Integrations\VK\VkPay\ApiClient => new VkPayApiClient(
            merchantUrl: (string) Config::get('vk_pay.merchant_url'),
            signatureService: $app->make(SignatureService::class),
            merchantId: (int) Config::get('vk_pay.merchant_id'),
        ));

        $this->app->bind(VkPayService::class, fn(Application $app): VkPayService => new VkPayService(
            merhcantPrivateKey: (string) Config::get('vk_pay.merchant_key'),
            appPrivateKey: (string) Config::get('vk.app_secret'),
            apiClient: $app->make(VkPayApiClient::class),
            userOrderService: $app->make(UserOrderService::class),
        ));

        $this->app->bind(VkPayOrderFactory::class, fn(Application $app): VkPayOrderFactory => new VkPayOrderFactory(
            vkPayService: $app->make(VkPayService::class),
            merchantId: (int) Config::get('vk_pay.merchant_id'),
        ));

        $this->app->bind(VkPayResponseFactory::class, fn(Application $app): VkPayResponseFactory => new VkPayResponseFactory(
            vkPayService: $app->make(VkPayService::class),
            signatureService: $app->make(SignatureService::class),
            transactionResultFactory: $app->make(VkPayTransactionResultFactory::class),
            merchantId: (int) Config::get('vk_pay.merchant_id'),
        ));

        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->register(HealthCheckProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
