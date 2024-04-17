<?php

namespace App\Services\Auth;

use App\Models\VkUser;
use App\Services\VkLaunchParamsService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

/**
 * Модуль 4. Разработка, Урок 9. Авторизация запросов к серверу мини-приложения #M4L9
 * Авторизация выполняется через механимз guard во фреймворке Laraverl.
 */
class VkLaunchParamsGuard implements Guard
{
    private ?Authenticatable $currentUser = null;

    public function __construct(
        private readonly Request               $request,
        private readonly UserProvider          $provider,
        private readonly VkLaunchParamsService $launchParamsService
    ) {
    }


    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return $this->user() !== null;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return null === $this->user();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if ($this->currentUser instanceof \Illuminate\Contracts\Auth\Authenticatable) {
            return $this->currentUser;
        }

        $launchParams = $this->launchParamsService->getLaunchParams($this->request);
        if (null === $launchParams
            || !$this->launchParamsService->isSigned($launchParams)
//            || $this->launchParamsService->isExpired($launchParams)
        ) {
            return null;
        }

        $user = $this->provider->retrieveById($launchParams->vk_user_id);
        if (!$user) {
            $user = new VkUser([
                'id' => $launchParams->vk_user_id
            ]);
            $user->saveOrFail();
        }
        $this->currentUser = $user;

        return $this->currentUser;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        if (null === $this->user()) {
            return null;
        }

        return $this->user()->getAuthIdentifier();
    }

    /**
     * Validate a user's credentials.
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        dd('validate', $credentials);
        return false;
    }

    /**
     * Determine if the guard has a user instance.
     *
     * @return bool
     */
    public function hasUser()
    {
        return null !== $this->user();
    }

    /**
     * Set the current user.
     */
    public function setUser(Authenticatable $user): void
    {
        $this->currentUser = $user;
    }
}
