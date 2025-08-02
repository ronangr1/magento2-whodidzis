<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Api\Data;

interface ConfigRecordInterface
{
    public const ENTITY_ID = 'entity_id';

    public const AUTHOR = 'author';

    public const SCOPE = 'scope';

    public const PATH = 'path';

    public const OLD_VALUE = 'old_value';

    public const NEW_VALUE = 'old_value';

    public const RECORDED_AT = 'recorded_at';

    public function getAuthor(): ?string;

    public function setAuthor(string $author): ConfigRecordInterface;

    public function getPath(): ?string;

    public function setPath(string $path): ConfigRecordInterface;

    public function getOldValue(): ?string;

    public function setOldValue(string $oldValue): ConfigRecordInterface;

    public function getNewValue(): ?string;

    public function setNewValue(string $newValue): ConfigRecordInterface;

    public function getScope(): string;

    public function setScope(string $scope): ConfigRecordInterface;

    public function getRecordedAt(): ?string;

    public function setRecordedAt(string $recordAt): ConfigRecordInterface;
}

