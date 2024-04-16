<?php

namespace App\Console\Commands;

use App\Models\VkUser;
use Illuminate\Console\Command;

class SwitchDonateFlagForUser extends Command
{
    protected $signature = 'app:switch-donate-flag';

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
