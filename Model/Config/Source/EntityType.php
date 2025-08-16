<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class EntityType implements OptionSourceInterface
{

    public function toOptionArray(): array
    {
        return [
            ['value' => 'Magento\Config\Model\Config', 'label' => 'Config'],
            ['value' => 'Magento\Cms\Model\Page', 'label' => 'Cms Page'],
            ['value' => 'Magento\Widget\Model\Widget\Instance', 'label' => 'Cms Widget'],
            ['value' => 'Magento\Cms\Model\Block', 'label' => 'Cms Block'],
            ['value' => 'Magento\Customer\Model\Customer', 'label' => 'Customer'],
            ['value' => 'Magento\Sales\Model\Order', 'label' => 'Order'],
            ['value' => 'Magento\Sales\Model\Order\Invoice', 'label' => 'Invoice'],
            ['value' => 'Magento\SalesRule\Model\Rule', 'label' => 'Sales Rule'],
            ['value' => 'Magento\CatalogRule\Model\Rule', 'label' => 'Catalog Rule'],
            ['value' => 'Magento\Email\Model\BackendTemplate', 'label' => 'Email Template'],
            ['value' => 'Magento\Integration\Model\Integration', 'label' => 'Integration'],
            ['value' => 'Magento\Integration\Model\Oauth\Consumer', 'label' => 'Oauth Consumer'],
        ];
    }
}
