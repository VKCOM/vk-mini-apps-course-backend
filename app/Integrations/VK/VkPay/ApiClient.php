<?php

declare(strict_types=1);

namespace App\Integrations\VK\VkPay;

use App\Components\VkPay\SignatureService;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Класс для работы с API vk pay и DMR
 */
final class ApiClient
{
    public function __construct(
        private readonly string $merchantUrl,
        private readonly SignatureService $signatureService,
        private readonly int $merchantId,
    ) {
    }


    public function makeRefund(string $transactionId, float $amount, string $reason = '', string $currency = 'RUB'): ReverseStatusResponse
    {
        $data = base64_encode(Json::encode([
            'header' => [
                'ts' => Carbon::now()->timestamp,
                'client_id' => (string)$this->merchantId
            ],
            'body' => [
                'transaction_id' => $transactionId,
                'amount' => (string)$amount,
                'currency' => $currency,
                'reason' => $reason,
            ],
        ]));

        $url = '/money/2-04/transaction/refund';

        $request = [
            'data' => $data,
            'version' => '2-04',
            'signature' => $this->signatureService->createSignature($data, $url),
        ];

        $response = Http::post($this->merchantUrl . $url . '?' . http_build_query($request));

        return $this->makeReverseStatusResponse($response);
    }

    public function makeReverse(
        string $transactionId,
        float  $amount,
        string $reason = '',
        string $currency = 'RUB',
    ): ReverseStatusResponse {
        $data = base64_encode(Json::encode([
            'body' => [
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'currency' => $currency,
                'reason' => $reason,
            ],
            'header' => [
                'ts' => Carbon::now()->timestamp,
                'client_id' => $this->merchantId
            ],
        ]));

        $url = '/money/2-04/vkpay/reverse';

        $request = [
            'data' => $data,
            'version' => '2-04',
            'signature' => $this->signatureService->createSignature($data, $url),
        ];

        $response = Http::post($this->merchantUrl . $url . '?' . http_build_query($request));

        return $this->makeReverseStatusResponse($response);
    }

    public function pullStatus(string $transactionId): ReverseStatusResponse
    {
        $url = '/money/2-04/transaction/status';

        $data = base64_encode(Json::encode([
            'body' => [
                'transaction_id' => $transactionId,
            ],
            'header' => [
                'ts' => Carbon::now()->timestamp,
                'client_id' => $this->merchantId
            ],
        ]));

        $request = [
            'data' => $data,
            'version' => '2-04',
            'signature' => $this->signatureService->createSignature($data, $url),
        ];

        $response = Http::post($this->merchantUrl . $url . '?' . http_build_query($request));

        return $this->makeReverseStatusResponse($response);
    }

    private function makeReverseStatusResponse(Response $response): ReverseStatusResponse
    {
        if (!$response->successful()) {
            throw $response->toException();
        }

        Log::debug('', $response->json());

        $data = $response->json('data');

        if (!$this->signatureService->validateSignature($data, $response->json('signature'))) {
            Log::error('Wrong signature', [
                'data' => $data,
                'signature' => $response->json('signature')
            ]);

            throw new \LogicException();
        }

        $json = json_decode(base64_decode((string) $data), true);

        if ($json['header']['status'] === 'ERROR') {
            Log::error('Error in vk pay response', [
                'response' => $json
            ]);

            throw new \LogicException();
        }

        return new ReverseStatusResponse(
            transactionId: (string)$json['body']['transaction_id'],
            status: TransactionStatusEnum::from($json['body']['action_param']['status']),
            transactionAction: TransactionActionEnum::from($json['body']['action']),
            rawData: $json,
        );
    }
}
