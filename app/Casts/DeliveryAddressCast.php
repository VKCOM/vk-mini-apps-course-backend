<?php

namespace App\Casts;

use App\Dto\DeliveryAddress;
use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddressCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!isset(
            $attributes['delivery_address_city'],
            $attributes['delivery_address_street'],
            $attributes['delivery_address_house'],
            $attributes['delivery_address_apartment'],
            $attributes['delivery_address_entrance'],
            $attributes['delivery_address_floor'],
            $attributes['delivery_address_comment'])
        ) {
            return null;
        }

        return new DeliveryAddress(
            $attributes['delivery_address_city'],
            $attributes['delivery_address_street'],
            $attributes['delivery_address_house'],
            $attributes['delivery_address_apartment'],
            $attributes['delivery_address_entrance'],
            $attributes['delivery_address_floor'],
            $attributes['delivery_address_comment'],
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (!$value instanceof DeliveryAddress) {
            throw new InvalidArgumentException('The given value is not an DeliveryAddress instance.');
        }

        return [
            'delivery_address_city' => $value->city,
            'delivery_address_street' => $value->street,
            'delivery_address_house' => $value->house,
            'delivery_address_apartment' => $value->apartment,
            'delivery_address_entrance' => $value->entrance,
            'delivery_address_floor' => $value->floor,
            'delivery_address_comment' => $value->comment,
        ];
    }
}
