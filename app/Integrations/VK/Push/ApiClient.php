<?php

declare(strict_types=1);

namespace App\Integrations\VK\Push;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class ApiClient
{
    public function __construct(private readonly string $baseUrl, private readonly string $accessToken, private readonly int $appId)
    {
    }

    public function isNotificationAllowed(int $userId): bool
    {
        $data = http_build_query([
            'user_id' => $userId,
            'apps_id' => $this->appId,
            'access_token' => $this->accessToken,
            'v' => '5.230',
        ]);

        $response = Http::post("{$this->baseUrl}/apps.isNotificationsAllowed?{$data}");
        Log::error($response->json());
        if (!$response->successful()) {
            return false;
        }

        return (bool) $response->json('response.is_allowed');
    }

    public function send(int $userId, string $text, string $fragment): bool
    {
        $data = http_build_query([
            'user_ids' => $userId,
            'message' => $text,
            'fragment' => $fragment,
            'access_token' => $this->accessToken,
            'v' => '5.230',
        ]);

        $response = Http::post("{$this->baseUrl}/notifications.sendMessage?{$data}");
        Log::error($response->json());
        if (!$response->successful()) {
            return false;
        }

        return isset($response->json('response')[0]['status']);
    }
}
