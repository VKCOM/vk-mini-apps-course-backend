<?php

declare(strict_types=1);

namespace App\Integrations\VK\Counter;

use Illuminate\Support\Facades\Http;

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
