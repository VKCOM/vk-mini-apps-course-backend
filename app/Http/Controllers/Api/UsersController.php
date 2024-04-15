<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserSelfResource;
use App\Models\VkUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function getById(VkUser $vkUser): JsonResource
    {
        $isAuthUser = Auth::id() === $vkUser->id;

        return $isAuthUser ? new UserSelfResource($vkUser) : new UserResource($vkUser);
    }
}
