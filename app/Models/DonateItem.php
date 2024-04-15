<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentItem
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $price
 * @property int $discount
 * @property int|null $period
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DonateItem whereCode($value)
 * @mixin \Eloquent
 */
class DonateItem extends Model
{
    use HasFactory;
}
