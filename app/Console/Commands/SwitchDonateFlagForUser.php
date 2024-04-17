<?php

namespace App\Console\Commands;

use App\Models\VkUser;
use Illuminate\Console\Command;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Команда для переключения возможности оплаты рекламы голосами
 */
class SwitchDonateFlagForUser extends Command
{
    protected $signature = 'app:switch-donate-flag {user-id}';

    protected $description = 'Command description';

    public function handle(): int
    {
        $userId = $this->argument('user-id');

        $vkUser = VkUser::whereId($userId)->firstOrFail();

        $vkUser->is_donates_enabled = !$vkUser->is_donates_enabled;

        $vkUser->save();

        return Command::SUCCESS;
    }
}
