<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ronangr1\WhoDidZis\Api\Data;

interface LogInterface
{
    const LOG_ID       = 'log_id';

    const ENTITY_TYPE  = 'entity_type';

    const ACTOR_ID    = 'actor_id';

    const ACTOR_TYPE   = 'actor_type';

    const ACTOR_NAME   = 'actor_name';

    const CREATED_AT   = 'created_at';

    const EVENT_TYPE   = 'event_type';

    const CHANGES_SUMMARY = 'changes_summary';

    public function getLogId(): ?int;

    public function setLogId($logId): self;

    public function getEntityType(): ?string;

    public function setEntityType(string $entityType): self;

    public function getActorId(): ?int;

    public function setActorId(int $actorId): self;

    public function getActorType(): ?string;

    public function setActorType(string $actorType): self;

    public function getActorName(): ?string;

    public function setActorName(string $actorName): self;

    public function getChangesSummary(): ?string;

    public function setChangesSummary(string $changesSummary): self;

    public function getCreatedAt(): ?string;

    public function setCreatedAt(string $createdAt): self;

    public function getEventType(): ?string;

    public function setEventType(string $eventType): self;
}
