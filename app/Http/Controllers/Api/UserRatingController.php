<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRatingRequest;
use App\Http\Resources\UserRatingResourceCollection;
use App\Models\VkUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserRatingController extends Controller
{
    public function getRating(UserRatingRequest $request): UserRatingResourceCollection
    {
        $friendIds = [];
        if ($request->has('friends')) {
            $friendIds = array_map('intval', $request->get('friends', []));
        }
        $usersBuilder = VkUser::query()->where('lvl', '>', 0)
            ->orderByDesc('lvl')->limit(50);
        if ($friendIds !== []) {
            $usersBuilder->whereIn('id', [Auth::id()] + $friendIds);
        }
        $users = $usersBuilder->withCount('completedOrders')->get();

        return new UserRatingResourceCollection($users);
    }
}
