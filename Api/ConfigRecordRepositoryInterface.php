<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Ronangr1\WhoDidZis\Api\Data\ConfigRecordInterface;

interface ConfigRecordRepositoryInterface
{
    public function save(
        ConfigRecordInterface $configRecord
    ): ConfigRecordInterface;

    public function get(string $entityId): ConfigRecordInterface;

    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): Data\ConfigRecordSearchResultsInterface;

    public function delete(
        ConfigRecordInterface $configRecord
    ): bool;

    /**
     * Delete Config Record by ID
     * @param string $entityId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(string $entityId): bool;
}

