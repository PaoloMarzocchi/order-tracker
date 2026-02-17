<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "creating" event.
     */
    public function creating(Order $order): void
    {
        if (empty($order->order_number)) {
            $order->order_number = Order::generateOrderNumber();
        }
    }

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updating" event.
     */
    public function updating(Order $order): void
    {
        if ($order->isDirty('status')) {
            $oldStatus = $order->getOriginal('status');
            $newStatus = $order->status;

            if (!$oldStatus->canTransitionTo($newStatus)) {
                throw new \Exception("Invalid status transition from $oldStatus->name to {$newStatus->name}");
            }
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
