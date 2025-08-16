<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ActorType implements OptionSourceInterface
{

    public function toOptionArray(): array
    {
        return [
            ['value' => 'admin', 'label' => 'Admin'],
            ['value' => 'cron', 'label' => 'Cron'],
            ['value' => 'customer', 'label' => 'Customer'],
            ['value' => 'cli_command', 'label' => 'Cli'],
            ['value' => 'system', 'label' => 'System'],
        ];
    }
}
