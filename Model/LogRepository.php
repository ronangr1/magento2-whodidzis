<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Ronangr1\WhoDidZis\Api\Data\LogInterface;
use Ronangr1\WhoDidZis\Api\Data\LogInterfaceFactory;
use Ronangr1\WhoDidZis\Api\Data\LogSearchResultsInterface;
use Ronangr1\WhoDidZis\Api\Data\LogSearchResultsInterfaceFactory;
use Ronangr1\WhoDidZis\Api\LogRepositoryInterface;
use Ronangr1\WhoDidZis\Model\ResourceModel\Log as ResourceLog;
use Ronangr1\WhoDidZis\Model\ResourceModel\Log\CollectionFactory as LogCollectionFactory;

class LogRepository implements LogRepositoryInterface
{
    public function __construct(
        private readonly ResourceLog $resource,
        private readonly LogInterfaceFactory $LogFactory,
        private readonly LogCollectionFactory $LogCollectionFactory,
        private readonly LogSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor
    ) {
    }

    /**
     * @inheritDoc
     */
    public function save(LogInterface $log
    ): LogInterface
    {
        try {
            $this->resource->save($log);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(
                __(
                    'Could not save the Log : %1',
                    $exception->getMessage()
                )
            );
        }
        return $log;
    }

    public function getList(
        SearchCriteriaInterface $criteria
    ): LogSearchResultsInterface {
        $collection = $this->LogCollectionFactory->create();

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

    public function deleteById(string $entityId): bool
    {
        return $this->delete($this->get($entityId));
    }

    /**
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(LogInterface $Log): bool
    {
        try {
            $LogModel = $this->LogFactory->create();
            $this->resource->load($LogModel, $Log->getEntityId());
            $this->resource->delete($LogModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(
                __(
                    'Could not delete the Log: %1',
                    $exception->getMessage()
                )
            );
        }
        return true;
    }

    public function get(string $entityId): LogInterface
    {
        $Log = $this->LogFactory->create();
        $this->resource->load($Log, $entityId);
        if (!$Log->getId()) {
            throw new NoSuchEntityException(__('Log with id "%1" does not exist.', $entityId));
        }
        return $Log;
    }
}

