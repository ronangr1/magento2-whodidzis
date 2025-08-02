<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model;

use Magento\Framework\Model\AbstractModel;
use Ronangr1\WhoDidZis\Api\Data\ConfigRecordInterface;

class ConfigRecord extends AbstractModel implements ConfigRecordInterface
{
    public function _construct(): void
    {
        $this->_init(ResourceModel\ConfigRecord::class);
    }

    public function getAuthor(): ?string
    {
        return $this->getData(self::AUTHOR);
    }

    public function setAuthor(string $author): ConfigRecordInterface
    {
        return $this->setData(self::AUTHOR, $author);
    }

    public function getPath(): ?string
    {
        return $this->getData(self::PATH);
    }

    public function setPath(string $path): ConfigRecordInterface
    {
        return $this->setData(self::PATH, $path);
    }

    public function getOldValue(): ?string
    {
        return $this->getData(self::OLD_VALUE);
    }

    public function setOldValue(string $oldValue): ConfigRecordInterface
    {
        return $this->setData(self::OLD_VALUE, $oldValue);
    }

    public function getNewValue(): ?string
    {
        return $this->getData(self::NEW_VALUE);
    }

    public function setNewValue(string $newValue): ConfigRecordInterface
    {
        return $this->setData(self::NEW_VALUE, $newValue);
    }

    public function getScope(): string
    {
        return $this->getData(self::SCOPE);
    }

    public function setScope(string $scope): ConfigRecordInterface
    {
        return $this->setData(self::SCOPE, $scope);
    }

    public function getRecordedAt(): ?string
    {
        return $this->getData(self::RECORDED_AT);
    }

    public function setRecordedAt(string $recordAt): ConfigRecordInterface
    {
        return $this->setData(self::RECORDED_AT, $recordAt);
    }
}

