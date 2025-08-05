<?php
/**
 *  * Copyright © Ronangr1. All rights reserved.
 *  * See COPYING.txt for license details.
 */

namespace Ronangr1\WhoDidZis\Api\Data;

interface LogInterface
{
    const LOG_ID       = 'log_id';

    const ENTITY_TYPE  = 'entity_type';

    const ENTITY_ID    = 'entity_id';

    const ACTOR_TYPE   = 'actor_type';

    const ACTOR_NAME   = 'actor_name';

    const BEFORE_DATA  = 'before_data';

    const AFTER_DATA   = 'after_data';

    const CREATED_AT   = 'created_at';

    const EVENT_TYPE   = 'event_type';

    public function getLogId(): ?int;

    public function setLogId($logId): self;

    public function getEntityType(): ?string;

    public function setEntityType(string $entityType): self;

    public function getEntityId(): ?int;

    public function setEntityId(int $entityId): self;

    public function getActorType(): ?string;

    public function setActorType(string $actorType): self;

    public function getActorName(): ?string;

    public function setActorName(string $actorName): self;

    public function getBeforeData(): ?string;

    public function setBeforeData(string $beforeData): self;

    public function getAfterData(): ?string;

    public function setAfterData(string $afterData): self;

    public function getCreatedAt(): ?string;

    public function setCreatedAt(string $createdAt): self;

    public function getEventType(): ?string;

    public function setEventType(string $eventType): self;
}
