<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case CustomerCancelled = 'customer_cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Processing => 'Processing',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::CustomerCancelled => 'Customer Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'yellow',
            self::Processing => 'blue',
            self::Completed => 'green',
            self::Cancelled => 'red',
            self::CustomerCancelled => 'red',
        };
    }

    public function canTransitionTo(OrderStatus $newStatus): bool
    {
        return match ($this) {
            self::Pending => in_array($newStatus, [self::Processing, self::Cancelled, self::CustomerCancelled]),
            self::Processing => in_array($newStatus, [self::Completed, self::Cancelled, self::CustomerCancelled]),
            self::Completed => false,
            self::Cancelled => false,
            self::CustomerCancelled => false,
        };
    }

    /**
     * Returns an array of OrderStatus values that cannot be updated to once set.
     * @return array
     */
    public static function cannotUpdateStatuses(): array
    {
        return [self::Completed->value, self::Cancelled->value, self::CustomerCancelled->value];
    }

    /**
     * Returns an array of OrderStatus cases for seeding the database, excluding CustomerCancelled.
     * @return array
     */
    public static function seederArray(): array
    {
        return array_filter(self::cases(), function ($status) {
            return $status !== self::CustomerCancelled;
        });
    }
}
