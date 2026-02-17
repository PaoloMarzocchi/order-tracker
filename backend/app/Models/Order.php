<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Observers\OrderObserver;
use App\Policies\OrderPolicy;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(OrderObserver::class)]
#[UsePolicy(OrderPolicy::class)]
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'status',
        'total_amount',
        'order_date',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'order_date' => 'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Generate a unique order number
     * @return string
     */
    public static function generateOrderNumber(): string
    {
        do {
            $order_number = fake()->numerify('########');
        } while (self::where('order_number', $order_number)->exists());

        return $order_number;
    }
}
