<?php

namespace App\Enums;

enum CommentStatusEnum: string
{
    case Published = 'Published';
    case UnPublished = 'UnPublished';

    public static function values(): array
    {
        return [
            self::Published->value,
            self::UnPublished->value,
        ];
    }
}
