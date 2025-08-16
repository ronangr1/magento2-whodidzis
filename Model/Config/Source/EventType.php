<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class EventType implements OptionSourceInterface
{

    public function toOptionArray(): array
    {
        return [
            ['value' => 'created', 'label' => 'Created'],
            ['value' => 'updated', 'label' => 'Updated'],
            ['value' => 'deleted', 'label' => 'Deleted'],
        ];
    }
}
