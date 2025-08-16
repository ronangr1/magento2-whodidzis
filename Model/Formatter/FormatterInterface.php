<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model\Formatter;

interface FormatterInterface
{
    public function format($object, array $originalData, array $newData): ?string;
}
