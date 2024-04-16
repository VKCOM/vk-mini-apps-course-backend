<?php

namespace App\Console\Commands;

use App\Models\VkUser;
use Illuminate\Console\Command;

class SwitchVkPayFlagForUser extends Command
{
    protected $signature = 'app:switch-vk-pay-flag';

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
