<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';
    case CASH_ON_DELIVERY = 'cash on delivery';
    case CARD = 'card';
    case FAILED = 'failed';
    public static function values(): array
    {
        return [
            self::PENDING->value,
            self::COMPLETED->value,
            self::CANCELLED->value,
            self::REFUNDED->value,
            self::CASH_ON_DELIVERY->value,
            self::FAILED->value,
            self::CARD->value,
        ];
    }
}
