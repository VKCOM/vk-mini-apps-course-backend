<?php

declare(strict_types=1);

namespace App\Components\VkPay;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Сервис для формирования и проверки подписи для платежной формы при оплате vk pay
 */
final class SignatureService
{
    public function __construct(private readonly string $signatureKey, private readonly string $merchanKey)
    {
    }

    public function createSignature(string $data, string $salt): string
    {
        return sha1("$salt{$data}{$this->merchanKey}");
    }

    public function validateSignature(string $data, string $originalSignature): bool
    {
        return (bool) openssl_verify(
            data: $data,
            signature: base64_decode($originalSignature),
            public_key: $this->signatureKey
        );
    }
}
