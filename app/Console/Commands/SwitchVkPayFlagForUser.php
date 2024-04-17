<?php

namespace App\Console\Commands;

use App\Models\VkUser;
use Illuminate\Console\Command;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Команда для переключения возможности оплаты заказов через vk pay
 */
class SwitchVkPayFlagForUser extends Command
{
    protected $signature = 'app:switch-vk-pay-flag {user-id}';

    protected $description = 'Command description';

    public function handle(): int
    {
        $userId = $this->argument('user-id');

        $vkUser = VkUser::whereId($userId)->firstOrFail();

        $vkUser->is_vk_pay_enabled = !$vkUser->is_vk_pay_enabled;

        $vkUser->save();

        return Command::SUCCESS;
    }
}
