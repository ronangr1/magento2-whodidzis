<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model\Actor;

class Type
{
    public const API = 'api';

    public const CRON = 'cron';

    public const CUSTOMER = 'customer';

    public const ADMIN = 'admin';

    public const CLI_COMMAND = 'cli_command';

    public const SYSTEM = 'system';
}
