<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonateRequest extends FormRequest
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
            'app_id' => 'numeric|nullable',
            'item' => 'nullable|string',
            'notification_type' => 'required|string',
            'order_id' => 'nullable|numeric',
            'item_photo_url' => 'string|nullable',
            'receiver_id' => 'numeric|nullable',
            'user_id' => 'required|numeric',
            'sig' => 'required|string',
            'status' => 'string|nullable',
            'item_id' => 'string|nullable',
            'item_title' => 'string|nullable',
            'item_price' => 'string|nullable',
            'date' => 'numeric|nullable',
            'lang' => 'string|nullable',
            'next_bill_time' => 'numeric|nullable',
            'subscription_id' => 'numeric|nullable',
            'cancel_reason' => 'string|nullable',
        ];
    }

    public function expectsJson(): bool
    {
        return false;
    }
}
