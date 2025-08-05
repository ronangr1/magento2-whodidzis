<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Service\System\Config;

use Magento\Framework\Exception\LocalizedException;
use Ronangr1\WhoDidZis\Api\LogRepositoryInterface;
use Ronangr1\WhoDidZis\Api\Data\LogInterfaceFactory;

class Record
{
    public function __construct(
        private readonly LogInterfaceFactory $logFactory,
        private readonly LogRepositoryInterface $logRepository
    ) {
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function record(array $data): bool
    {
        if (empty($data)) {
            throw new LocalizedException(__("Array cannot be empty."));
        }

        try {
            $record = $this->logFactory->create();
            $record->setData($data);
            $this->logRepository->save($record);
        } catch (\Exception) {
            return false;
        }
        return true;
    }
}
