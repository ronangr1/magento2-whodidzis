<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Enum;

enum ActorType: string
{
    case API = 'api';

    case CRON = 'cron';

    case CUSTOMER = 'customer';

    case ADMIN = 'admin';

    case CLI_COMMAND = 'cli_command';

    case SYSTEM = 'system';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
