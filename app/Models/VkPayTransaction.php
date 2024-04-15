<?php

namespace App\Models;

use App\Enums\VkPayTransactionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\VkPayTransaction
 *
 * @property int $id
 * @property int $user_order_id
 * @property string $order_uuid
 * @property string $transaction_id
 * @property float $amount
 * @property string $currency
 * @property VkPayTransactionStatusEnum $status
 * @property array $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereOrderUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkPayTransaction whereUserOrderId($value)
 * @property-read UserOrder userOrder
 * @mixin \Eloquent
 */
class VkPayTransaction extends Model
{
    use HasFactory;

    protected $casts = [
        'meta' => 'array',
        'status' => VkPayTransactionStatusEnum::class,
    ];

    protected $fillable = [
        'status',
        'transaction_id',
        'meta',
    ];

    public function userOrder(): BelongsTo
    {
        return $this->belongsTo(UserOrder::class, 'user_order_id');
    }
}
