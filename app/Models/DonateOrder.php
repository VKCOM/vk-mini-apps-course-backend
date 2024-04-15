<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DonateOrder
 *
 * @property int $id
 * @property string $external_order_id
 * @property string $subscription_id
 * @property int $donate_item_id
 * @property int $vk_user_id
 * @property int $price
 * @property Carbon $active_to
 * @property string $type
 * @property string $status
 * @property array $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereActiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereDonateItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereExternalOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateOrder whereVkUserId($value)
 * @mixin \Eloquent
 */
class DonateOrder extends Model
{
    use HasFactory;

    protected $casts = [
        'meta' => 'array',
        'active_to' => 'datetime'
    ];

    protected $fillable = [
        'status', 'type', 'meta'
    ];
}
