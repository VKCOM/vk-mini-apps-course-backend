<?php

namespace App\Http\Controllers\Api;

use App\Enums\AchievementsCodeEnum;
use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Restaurant;
use App\Models\UserAchievement;
use App\Models\UserFavourite;
use App\Models\VkUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function setFavourite(Restaurant $restaurant): JsonResponse
    {
        /** @var VkUser $user */
        $user = Auth::user();
        $isDeleted = (bool) UserFavourite::query()
            ->where('vk_user_id', '=', $user->id)
            ->where('restaurant_id', '=', $restaurant->id)
            ->delete();


        if (!$isDeleted) {
            UserFavourite::create([
                'vk_user_id' => $user->id,
                'restaurant_id' => $restaurant->id,
            ]);

            $achievementId = Achievement::whereCode(AchievementsCodeEnum::FAVOURITE)->firstOrFail()->id;
            if ($user->achievements->firstWhere('id', '=', $achievementId) === null) {
                $achievement = new UserAchievement();
                $achievement->vk_user_id = $user->id;
                $achievement->achievement_id = $achievementId;
                $achievement->save();
            }
        }

        return response()->json(['data' => true]);
    }
}
