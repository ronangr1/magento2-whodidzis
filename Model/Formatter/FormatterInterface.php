<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ronangr1\WhoDidZis\Model\Formatter;

use Magento\Framework\Model\AbstractModel;

interface FormatterInterface
{
    public function format($object, array $originalData, array $newData): ?string;
}
