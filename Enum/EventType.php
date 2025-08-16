<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Enum;

enum EventType: string
{
    case TYPE_CREATED = 'created';

    case TYPE_UPDATED = 'updated';

    case TYPE_DELETED = 'deleted';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
