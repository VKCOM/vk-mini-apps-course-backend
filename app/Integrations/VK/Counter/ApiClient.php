<?php

declare(strict_types=1);

namespace App\Integrations\VK\Counter;

use Illuminate\Support\Facades\Http;

/**
 * Модуль 4. Разработка, Урок 18. Счётчики и бейджи #M4L18
 * Класс установки значения в счётчик мини-приложения
 * Обратите внимание, что мы не инкрементируем значение счётчика, а перезаписываем его.
 * Обнуление значения счётчика происходит путём установки его в нулевое значение: ApiClient::setCounter(user_id, 0)
 * @see ApiClient::setCounter - установка значение счетчика для пользователя
 */
final class ApiClient
{
    public function __construct(private readonly string $defaultUrl, private readonly string $accessToken)
    {
    }

    public function setCounter(int $userId, int $counter): void
    {
        $data = http_build_query([
            'user_id' => $userId,
            'counter' => $counter,
            'v' => '5.230',
            'access_token' => $this->accessToken,
        ]);

        Http::post("{$this->defaultUrl}/secure.setCounter?{$data}");
    }
}
