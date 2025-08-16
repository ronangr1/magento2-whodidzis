<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ronangr1\WhoDidZis\Api;

use Ronangr1\WhoDidZis\Api\Data\LogInterface;

interface LogRepositoryInterface
{
    public function get(string $entityId): LogInterface;

    public function save(LogInterface $log);
}
