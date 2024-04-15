<?php

use App\Http\Controllers\Api\DishController;
use App\Http\Controllers\Api\DonateController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\UserRatingController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VkPayController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::middleware('auth:mini_app')->group(function () {
    Route::get('/dishes', [DishController::class, 'list']);
    Route::get('/dishes/{dish}', [DishController::class, 'getById']);

    Route::get('/payments/vote/products', [DonateController::class, 'getProducts']);

    Route::post('/orders', [OrderController::class, 'createOrder']);
    Route::post('/orders/{order}', [OrderController::class, 'updateOrder']);
    Route::get('/orders/{order}', [OrderController::class, 'getOrder']);
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancelOrder']);
    Route::post('/orders/{order}/rate', [OrderController::class, 'rateOrder']);

    Route::post('/restaurant/{restaurant}/set-favorite', [RestaurantController::class, 'setFavourite']);

    Route::post('/users/rating', [UserRatingController::class, 'getRating']);
    Route::get('/users/{vkUser}/active-order', [OrderController::class, 'getUserActiveOrder']);
    Route::get('/users/{vkUser}', [UsersController::class, 'getById']);
    Route::get('/users/{vkUser}/orders', [OrderController::class, 'getUserOrders']);
    Route::post('/users/{vkUser}/set-notifications', [NotificationController::class, 'setNotifications']);
    Route::post('/users/{vkUser}/set-orders-public', [OrderController::class, 'setOrdersPublic']);
    Route::get('/users/{vkUser}/notifications', [NotificationController::class, 'getUserNotifications']);
    Route::post('/users/{vkUser}/notifications/mark-as-viewed', [NotificationController::class, 'markNotificationsAsViewed']);

    Route::get('orders/{order}/vkpay-data', [VkPayController::class, 'getPaymentData']);
});

Route::any('/donate/vote/callback', [DonateController::class, 'handle']);

Route::any('/payments/vkpay/callback', [VkPayController::class, 'handleCallback']);
