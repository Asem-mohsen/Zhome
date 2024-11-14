<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    public static function values(): array
    {
        return [
            self::PENDING->value,
            self::COMPLETED->value,
            self::CANCELLED->value,
            self::REFUNDED->value,
        ];
    }
}
