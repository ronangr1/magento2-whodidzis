<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Ronangr1\WhoDidZis\Api\Data\LogInterface;
use Ronangr1\WhoDidZis\Model\ResourceModel\Log as LogResourceModel;

class Log extends AbstractModel implements LogInterface, IdentityInterface
{
    const CACHE_TAG = 'ronangr1_whodidzis_log';

    protected $_cacheTag = self::CACHE_TAG;

    protected $_eventPrefix = 'ronangr1_whodidzis_log';

    protected function _construct(): void
    {
        $this->_init(LogResourceModel::class);
    }

    public function getLogId(): ?int
    {
        $id = $this->getData(self::LOG_ID);
        return $id === null ? null : (int)$id;
    }

    public function setLogId($logId): LogInterface
    {
        return $this->setData(self::LOG_ID, $logId);
    }

    public function getEntityType(): ?string
    {
        return $this->getData(self::ENTITY_TYPE);
    }

    public function setEntityType(string $entityType): LogInterface
    {
        return $this->setData(self::ENTITY_TYPE, $entityType);
    }

    public function getEntityId(): ?int
    {
        $id = $this->getData(self::ENTITY_ID);
        return $id === null ? null : (int)$id;
    }

    public function setEntityId($entityId): LogInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    public function getActorType(): ?string
    {
        return $this->getData(self::ACTOR_TYPE);
    }

    public function setActorType(string $actorType): LogInterface
    {
        return $this->setData(self::ACTOR_TYPE, $actorType);
    }

    public function getActorName(): ?string
    {
        return $this->getData(self::ACTOR_NAME);
    }

    public function setActorName(string $actorName): LogInterface
    {
        return $this->setData(self::ACTOR_NAME, $actorName);
    }

    public function getBeforeData(): ?string
    {
        return $this->getData(self::BEFORE_DATA);
    }

    public function setBeforeData(string $beforeData): LogInterface
    {
        return $this->setData(self::BEFORE_DATA, $beforeData);
    }

    public function getAfterData(): ?string
    {
        return $this->getData(self::AFTER_DATA);
    }

    public function setAfterData(string $afterData): LogInterface
    {
        return $this->setData(self::AFTER_DATA, $afterData);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): LogInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getEventType(): ?string
    {
        return $this->getData(self::EVENT_TYPE);
    }

    public function setEventType(string $eventType): LogInterface
    {
        return $this->setData(self::EVENT_TYPE, $eventType);
    }

    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
