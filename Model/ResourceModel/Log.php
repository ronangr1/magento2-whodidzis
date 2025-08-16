<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Log extends AbstractDb
{
    private const TABLE_NAME = 'whodidzis_log';

    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, 'log_id');
    }
}

