<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DishResource;
use App\Http\Resources\DishResourceCollection;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DishController extends Controller
{
    public function list(): DishResourceCollection
    {
        $dishes = Dish::with('restaurant')->get();

        return new DishResourceCollection($dishes, Auth::user());
    }

    public function getById(Dish $dish): DishResource
    {
        return new DishResource($dish, Auth::user());
    }
}
