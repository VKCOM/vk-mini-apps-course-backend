<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address' => 'required|array',
            'address.city' => 'required|string',
            'address.street' => 'required|string',
            'address.house' => 'required|string',
            'address.apartment' => 'string|nullable',
            'address.entrance' => 'string|nullable',
            'address.floor' => 'string|nullable',
            'address.comment' => 'string|nullable',
            'extra_options' => 'array',
            'extra_options.*' => 'string',
            'is_discount_activated' => 'required|boolean',
        ];
    }
}
