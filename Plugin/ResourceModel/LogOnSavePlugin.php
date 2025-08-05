<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Plugin\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Ronangr1\WhoDidZis\Service\Log\SaveHandler;

class LogOnSavePlugin
{
    public function __construct(
        private readonly SaveHandler $saveHandler
    ) {
    }

    public function aroundSave(AbstractDb $subject, \Closure $proceed, AbstractModel $object): AbstractDb
    {
        $isObjectNew = $object->isObjectNew();

        $originalData = $object->getOrigData() ?? [];
        $newData = $object->getData();

        $result = $proceed($object);

        $this->saveHandler->handle(
            $object,
            $originalData,
            $newData,
            $isObjectNew
        );

        return $result;
    }
}
