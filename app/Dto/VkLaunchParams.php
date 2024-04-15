<?php

namespace App\Dto;

use Illuminate\Support\Str;

class VkLaunchParams
{
    public readonly int $vk_user_id;
    public readonly int $vk_app_id;
    public readonly ?int $vk_chat_id;
    public readonly bool $vk_is_app_user;
    public readonly bool $vk_are_notifications_enabled;
    public readonly string $vk_language;
    public readonly string $vk_ref;
    public readonly ?string $vk_access_token_settings;
    public readonly ?int $vk_group_id;
    public readonly ?string $vk_viewer_group_role;
    public readonly string $vk_platform;
    public readonly bool $vk_is_favorite;
    public readonly int $vk_ts;
    public readonly bool $vk_is_recommended;
    public readonly ?int $vk_profile_id;
    public readonly bool $vk_has_profile_button;
    public readonly ?int $vk_testing_group_id;
    public readonly string $sign;
    public readonly bool $odr_enabled;

    public function __construct(protected readonly array $data)
    {
        $this->vk_user_id = $this->data['vk_user_id'] ?? 0;
        $this->vk_app_id = $this->data['vk_app_id'] ?? 0;
        $this->vk_chat_id = $this->data['vk_chat_id'] ?? null;
        $this->vk_is_app_user = $this->data['vk_is_app_user'] ?? false;
        $this->vk_are_notifications_enabled = $this->data['vk_are_notifications_enabled'] ?? false;
        $this->vk_language = $this->data['vk_language'] ?? 'undefined';
        $this->vk_ref = $this->data['vk_ref'] ?? 'other';
        $this->vk_access_token_settings = $this->data['vk_access_token_settings'] ?? '';
        $this->vk_group_id = $this->data['vk_group_id'] ?? null;
        $this->vk_viewer_group_role = $this->data['vk_viewer_group_role'] ?? null;
        $this->vk_platform = $this->data['vk_platform'] ?? 'undefined';
        $this->vk_is_favorite = $this->data['vk_is_favorite'] ?? false;
        $this->vk_ts = $this->data['vk_ts'] ?? 0;
        $this->vk_is_recommended = $this->data['vk_is_recommended'] ?? false;
        $this->vk_profile_id = $this->data['vk_profile_id'] ?? null;
        $this->vk_has_profile_button = $this->data['vk_has_profile_button'] ?? false;
        $this->vk_testing_group_id = $this->data['vk_testing_group_id'] ?? null;
        $this->sign = $this->data['sign'] ?? '';
        $this->odr_enabled = $this->data['odr_enabled'] ?? false;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
