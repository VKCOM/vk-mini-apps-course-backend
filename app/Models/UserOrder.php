<?php

namespace App\Models;

use App\Casts\DeliveryAddressCast;
use App\Casts\DishOptionsCast;
use App\Casts\ExtraDishOptionsCast;
use App\Dto\DeliveryAddress;
use App\Dto\DishOption;
use App\Dto\ExtraDishOption;
use App\Enums\UserOrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\UserOrder
 *
 * @property int $id
 * @property int $vk_user_id
 * @property int $dish_id
 * @property UserOrderStatusEnum $status
 * @property DishOption[] $dish_options
 * @property ExtraDishOption[] $extra_options
 * @property float $discount
 * @property Carbon $delivery_planned_at
 * @property float $delivery_price
 * @property ?DeliveryAddress $delivery_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDeliveryAddressApartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDeliveryAddressCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDeliveryAddressComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDeliveryAddressEntrance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDeliveryAddressFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDeliveryAddressHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDeliveryAddressStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDeliveryPlannedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDeliveryPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDishId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereDishOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereExtraOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereVkUserId($value)
 * @property string $delivery_address_city
 * @property string $delivery_address_street
 * @property string $delivery_address_house
 * @property string $delivery_address_apartment
 * @property string $delivery_address_entrance
 * @property string $delivery_address_floor
 * @property string $delivery_address_comment
 * @property-read \App\Models\Dish $dish
 * @property float|null $total_price
 * @property string|null $rate
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereTotalPrice($value)
 * @property-read \App\Models\VkUser $user
 * @mixin \Eloquent
 */
class UserOrder extends Model
{
    use HasFactory;

    protected $casts = [
        'dish_options' => DishOptionsCast::class,
        'extra_options' => ExtraDishOptionsCast::class,
        'delivery_address' => DeliveryAddressCast::class,
        'discount' => 'float',
        'delivery_price' => 'float',
        'total_price' => 'float',
        'rate' => 'integer',
        'delivery_planned_at' => 'datetime',
        'status' => UserOrderStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(VkUser::class, 'vk_user_id');
    }

    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

    public function getTransactions(): HasMany
    {
        return $this->hasMany(VkPayTransaction::class);
    }
}
