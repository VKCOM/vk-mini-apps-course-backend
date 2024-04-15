<?php

namespace App\Casts;

use App\Dto\DishOption;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DishOptionsCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $items = [];

        if (empty($value)) {
            return $items;
        }

        $valueItems = json_decode((string) $value, true);
        if (!is_array($valueItems)) {
            return $items;
        }

        return array_map(
            fn (array $valueItem): \App\Dto\DishOption => new DishOption(
                $valueItem['id'],
                $valueItem['name'],
                $valueItem['price'],
            ),
            $valueItems
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return is_array($value) ? json_encode($value) : $value;
    }
}
