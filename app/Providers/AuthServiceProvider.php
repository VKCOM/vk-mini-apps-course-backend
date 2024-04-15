<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Services\Auth\VkLaunchParamsGuard;
use App\Services\VkLaunchParamsService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Auth::extend('vk_launch_params', function (Application $app, string $name, array $config): \App\Services\Auth\VkLaunchParamsGuard {
            /** @var Request $request */
            $request = $app->get('request');
            return new VkLaunchParamsGuard(
                $request,
                Auth::createUserProvider($config['provider']),
                $app->make(VkLaunchParamsService::class)
            );
        });
    }
}
