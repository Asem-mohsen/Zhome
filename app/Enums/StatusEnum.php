<?php

namespace App\Enums;

enum StatusEnum: string
{
    case ACTIVE = 'active';
    case DISACTIVE = 'disactive';
    case DELETED = 'deleted';

    /**
     * Return all possible status values.
     */
    public static function values(): array
    {
        return [
            self::ACTIVE->value,
            self::DISACTIVE->value,
            self::DELETED->value,
        ];
    }
}
