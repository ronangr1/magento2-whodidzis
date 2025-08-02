<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Ronangr1\WhoDidZis\Api\ConfigRecordRepositoryInterface;
use Ronangr1\WhoDidZis\Api\Data\ConfigRecordInterface;
use Ronangr1\WhoDidZis\Api\Data\ConfigRecordInterfaceFactory;
use Ronangr1\WhoDidZis\Api\Data\ConfigRecordSearchResultsInterface;
use Ronangr1\WhoDidZis\Api\Data\ConfigRecordSearchResultsInterfaceFactory;
use Ronangr1\WhoDidZis\Model\ResourceModel\ConfigRecord as ResourceConfigRecord;
use Ronangr1\WhoDidZis\Model\ResourceModel\ConfigRecord\CollectionFactory as ConfigRecordCollectionFactory;

class ConfigRecordRepository implements ConfigRecordRepositoryInterface
{
    public function __construct(
        private readonly ResourceConfigRecord $resource,
        private readonly ConfigRecordInterfaceFactory $configRecordFactory,
        private readonly ConfigRecordCollectionFactory $configRecordCollectionFactory,
        private readonly ConfigRecordSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(ConfigRecordInterface $configRecord): ConfigRecordInterface
    {
        try {
            $this->resource->save($configRecord);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __(
                    'Could not save the Config Record : %1',
                    $exception->getMessage()
                )
            );
        }
        return $configRecord;
    }

    public function get(string $entityId): ConfigRecordInterface
    {
        $configRecord = $this->configRecordFactory->create();
        $this->resource->load($configRecord, $entityId);
        if (!$configRecord->getId()) {
            throw new NoSuchEntityException(__('Config Record with id "%1" does not exist.', $entityId));
        }
        return $configRecord;
    }

    public function getList(
        SearchCriteriaInterface $criteria
    ): ConfigRecordSearchResultsInterface {
        $collection = $this->configRecordCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(ConfigRecordInterface $configRecord): bool
    {
        try {
            $configRecordModel = $this->configRecordFactory->create();
            $this->resource->load($configRecordModel, $configRecord->getEntityId());
            $this->resource->delete($configRecordModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __(
                    'Could not delete the Config Record: %1',
                    $exception->getMessage()
                )
            );
        }
        return true;
    }

    public function deleteById(string $entityId): bool
    {
        return $this->delete($this->get($entityId));
    }
}

