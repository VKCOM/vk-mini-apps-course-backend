<?php

namespace App\Services;

use App\Dto\VkLaunchParams;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Модуль 4. Разработка, Урок 9. Авторизация запросов к серверу мини-приложения #M4L9
 * Сервис проверки параметров запуска и проверки авторизации
 * @see VkLaunchParamsService::isSigned  - проверка подписи параметров запуска
 * @see VkLaunchParamsService::isExpired - проверка времени жизни токена
 */
class VkLaunchParamsService
{
    public function __construct(
        private readonly int    $appId,
        private readonly string $appSecret
    ) {
    }

    public function getLaunchParams(Request $request): ?VkLaunchParams
    {
        $queryParamsUrl = $this->extractQueryParamsAsUrl($request);
        if ($queryParamsUrl === null || $queryParamsUrl === '' || $queryParamsUrl === '0') {
            return null;
        }

        $queryParams = $this->extractQueryParamsAsArray($queryParamsUrl);
        if ($queryParams === []) {
            return null;
        }

        return new VkLaunchParams($queryParams);
    }

    protected function extractQueryParamsAsUrl(Request $request): ?string
    {
        if (!$request->hasHeader('Authorization')) {
            return null;
        }

        $authorizationHeader = $request->header('Authorization', '');
        if (!Str::startsWith($authorizationHeader, 'VK')) {
            return null;
        }

        return base64_decode(trim(Str::replace('VK', '', $authorizationHeader)));
    }

    protected function extractQueryParamsAsArray(string $queryParamsUrl): array
    {
        $queryParams = [];
        parse_str(parse_url($queryParamsUrl, PHP_URL_QUERY), $queryParams);

        return $queryParams;
    }

    public function isSigned(VkLaunchParams $launchParams): bool
    {
        if ($this->appId !== $launchParams->vk_app_id) {
            return false;
        }

        $vkParams = [];
        foreach ($launchParams->getData() as $paramName => $value) {
            if (!Str::startsWith($paramName, 'vk_')) { // Получаем только vk параметры из query
                continue;
            }

            $vkParams[$paramName] = $value;
        }
        ksort($vkParams); // Сортируем массив по ключам

        $signParamsQuery = http_build_query($vkParams); // Формируем строку вида "param_name1=value&param_name2=value"
        $sign = rtrim(strtr(base64_encode(hash_hmac('sha256', $signParamsQuery, $this->appSecret, true)), '+/', '-_'), '='); // Получаем хеш-код от строки, используя защищённый ключ приложения. Генерация на основе метода HMAC.

        return $sign === $launchParams->sign; // Сравниваем полученную подпись со значением параметра 'sign'
    }

    public function isExpired(VkLaunchParams $launchParams): bool
    {
        $timestamp = Carbon::createFromTimestamp($launchParams->vk_ts);

        $now = Carbon::now();

        return $now->diffInHours($timestamp) > 1;
    }
}
