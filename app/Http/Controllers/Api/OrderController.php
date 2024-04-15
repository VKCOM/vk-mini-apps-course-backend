<?php

namespace App\Http\Controllers\Api;

use App\Dto\DeliveryAddress;
use App\Dto\DishOption;
use App\Enums\UserOrderStatusEnum;
use App\Events\OrderCanceled;
use App\Events\OrderUpdated;
use App\Events\OrderWasRateEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\RateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderResourceCollection;
use App\Models\Dish;
use App\Models\UserOrder;
use App\Models\VkUser;
use App\Services\UserOrderService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class OrderController extends Controller
{
    public function getUserOrders(VkUser $vkUser): OrderResourceCollection
    {
        $authUserId = Auth::id();
        $orders = $vkUser->id === $authUserId || $vkUser->is_orders_public ? $vkUser->orders : new Collection([]);

        return new OrderResourceCollection($orders, $authUserId);
    }

    public function createOrder(CreateOrderRequest $request): OrderResource
    {
        $requestDishId = $request->get('dish_id');
        $requestDishOptions = (array)$request->get('dish_options', []);

        $dish = Dish::whereId($requestDishId)->firstOrFail();
        $dishOptions = (new Collection($dish->dish_options))->whereIn('id', $requestDishOptions);
        if (count($requestDishOptions) !== $dishOptions->count()) {
            throw new BadRequestException('Bad dish options');
        }

        $order = new UserOrder();
        $order->vk_user_id = Auth::id();
        $order->dish_id = $dish->id;
        $order->status = UserOrderStatusEnum::NEW;
        $order->total_price = $dish->price + $dishOptions->sum(fn (DishOption $o): float => $o->price);
        $order->dish_options = $dishOptions->toArray();
        if (!$order->save()) {
            throw new InternalErrorException('Order not created');
        }

        return new OrderResource($order, Auth::id());
    }

    public function updateOrder(UpdateOrderRequest $request, UserOrder $order, UserOrderService $userOrderService): OrderResource
    {
        if (Auth::id() !== $order->vk_user_id) {
            abort(403);
        }
        if ($order->status !== UserOrderStatusEnum::NEW) {
            abort(403);
        }
        $requestAddress = $request->get('address', []);
        $requestAddress = new DeliveryAddress(
            $requestAddress['city'] ?? '',
            $requestAddress['street'] ?? '',
            $requestAddress['house'] ?? '',
            $requestAddress['apartment'] ?? '',
            $requestAddress['entrance'] ?? '',
            $requestAddress['floor'] ?? '',
            $requestAddress['comment'] ?? '',
        );
        $requestExtraOptions = (array)$request->get('extra_options', []);
        $requestIsDiscountActivated = (bool)$request->get('is_discount_activated', false);

        $dish = $order->dish;
        $extraOptions = (new Collection($dish->extra_options))->whereIn('id', $requestExtraOptions);
        if (count($requestExtraOptions) !== $extraOptions->count()) {
            throw new BadRequestException('Bad extra options');
        }

        $userOrderService->transferToAwaitingPayment(
            order: $order,
            extraOptions: $extraOptions,
            deliveryAddress: $requestAddress,
            withAdvDiscount: $requestIsDiscountActivated,
        );

        return new OrderResource($order, Auth::id());
    }

    public function getOrder(UserOrder $order, UserOrderService $userOrderService): OrderResource
    {
        if (Auth::id() !== $order->vk_user_id) {
            abort(403);
        }

        $userOrderService->transferToNextStatus($order);

        return new OrderResource($order, Auth::id());
    }

    public function cancelOrder(UserOrder $order): OrderResource
    {
        if (Auth::id() !== $order->vk_user_id) {
            abort(403);
        }
        if ($order->status === UserOrderStatusEnum::CANCELED || $order->status === UserOrderStatusEnum::COMPLETED) {
            abort(400, 'Order is canceled or completed');
        }

        $order->status = UserOrderStatusEnum::CANCELED;
        if (!$order->save()) {
            throw new InternalErrorException('Order not canceled');
        }

        event(new OrderCanceled($order));

        return new OrderResource($order, Auth::id());
    }

    public function rateOrder(RateOrderRequest $request, UserOrder $order): OrderResource
    {
        if (Auth::id() !== $order->vk_user_id) {
            abort(403);
        }
        if ($order->status !== UserOrderStatusEnum::COMPLETED) {
            abort(400, 'Order is not completed');
        }

        $order->rate = $request->get('rate');
        if (!$order->save()) {
            throw new InternalErrorException('Order not rated');
        }

        event(new OrderWasRateEvent($order->dish->restaurant));

        return new OrderResource($order, Auth::id());
    }


    public function setOrdersPublic(VkUser $vkUser): JsonResponse
    {
        $authUserId = Auth::id();
        if ($vkUser->id !== $authUserId) {
            abort(403);
        }

        $vkUser->is_orders_public = !$vkUser->is_orders_public;
        $result = $vkUser->save();

        return response()->json(['data' => $result]);
    }

    public function getUserActiveOrder(VkUser $vkUser, UserOrderService $userOrderService): JsonResponse|OrderResource
    {
        $authUserId = Auth::id();
        if ($vkUser->id !== $authUserId) {
            abort(403);
        }

        $order = $userOrderService->getActiveOrderByVkUser($vkUser);

        if ($order === null) {
            return response()->json(['data' => null]);
        }

        return new OrderResource($order, $authUserId);
    }
}
