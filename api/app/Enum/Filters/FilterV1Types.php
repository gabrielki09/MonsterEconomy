<?php

namespace App\Enum\Filters;

enum FilterV1Types: string
{
    case Equal = 'EQUAL';
    case NotEqual = 'NOT_EQUAL';
    case ILike = 'ILIKE';
    case Like = 'LIKE';

    case GreaterThan = 'GREATER_THAN';
    case GreaterThanOrEqual = 'GREATER_THAN_OR_EQUAL';
    case LessThan = 'LESS_THAN';
    case LessThanOrEqual = 'LESS_THAN_OR_EQUAL';

    case In = 'IN';
    case NotIn = 'NOT_IN';

    case IsNull = 'NULL';
    case IsNotNull = 'NOT_NULL';

    public function requiresValue(): bool
    {
        return !in_array(
            $this,
            [
                self::IsNull,
                self::IsNotNull,
            ],
            true
        );
    }
}
