<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => [
                'required',
                'exists:customers,id'
            ],
            'order_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Order::class)->ignore($this->order->id)
            ],
            'total_amount' => [
                'required',
                'numeric',
                'min:0'
            ],
            'status' => [
                'required',
                Rule::in(array_column(OrderStatus::cases(), 'value'))
            ],
            'order_date' => [
                'required',
                'date'
            ],
        ];
    }
}
