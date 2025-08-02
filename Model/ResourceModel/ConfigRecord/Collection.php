<?php

/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model\ResourceModel\ConfigRecord;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Ronangr1\WhoDidZis\Model\ConfigRecord;
use Ronangr1\WhoDidZis\Model\ResourceModel\ConfigRecord as ConfigRecordResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct(): void
    {
        $this->_init(
            ConfigRecord::class,
            ConfigRecordResourceModel::class
        );
    }
}

