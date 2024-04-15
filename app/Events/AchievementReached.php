<?php

namespace App\Events;

use App\Models\UserAchievement;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AchievementReached
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(private UserAchievement $achievement)
    {
    }

    public function getAchievement(): UserAchievement
    {
        return $this->achievement;
    }
}
