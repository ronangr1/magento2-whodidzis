<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Service\Log;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Serialize\JsonConverter;
use Psr\Log\LoggerInterface;
use Ronangr1\WhoDidZis\Model\Actor\Type as ActorType;
use Ronangr1\WhoDidZis\Model\Event\Type;
use Ronangr1\WhoDidZis\Model\Formatter\FormatterInterface;
use Ronangr1\WhoDidZis\Resolver\ActorResolverInterface;
use Ronangr1\WhoDidZis\Api\Data\LogInterfaceFactory;
use Ronangr1\WhoDidZis\Api\LogRepositoryInterface;

class SaveHandler
{

    public function __construct(
        private readonly ActorResolverInterface $actorResolver,
        private readonly LogRepositoryInterface $logRepository,
        private readonly LogInterfaceFactory $logFactory,
        private readonly LoggerInterface $logger,
        private readonly FormatterHandler $formatterHandler,
        private readonly array $deniedEntityTypes = [],
        private readonly array $contextualDeniedEntityTypes = [],
    ) {
    }

    public function handle(AbstractModel $object, ?array $originalData, array $newData, bool $isObjectNew): void
    {
        if (!$this->hasChanges($originalData, $newData, $isObjectNew)) {
            return;
        }

        $entityType = get_class($object);
        if (str_contains($entityType, 'Interceptor')) {
            $entityType = get_parent_class($entityType);
        }

        if (in_array($entityType, $this->deniedEntityTypes)) {
            return;
        }

        if (in_array($entityType, $this->contextualDeniedEntityTypes)) {
            $actor = $this->actorResolver->getCurrentActor();
            if ($actor->getActorType() !== ActorType::ADMIN) {
                return;
            }
        }

        $formatter = $this->formatterHandler->getFormatterForEntity($entityType);
        $logContent = $formatter->format($object, $originalData ?? [], $newData);

        if ($logContent === null) {
            return;
        }

        try {
            $log = $this->logFactory->create();

            $actor = $this->actorResolver->getCurrentActor();

            $log->setEntityType($entityType);
            $log->setActorId($actor->getId());
            $log->setActorType($actor->getType());
            $log->setActorName($actor->getName());
            $log->setEventType(Type::TYPE_CREATED);
            $log->setChangesSummary($logContent);
            if ($isObjectNew) {
                $log->setEventType(Type::TYPE_CREATED);
            } else {
                $log->setEventType(Type::TYPE_UPDATED);
            }
            $this->logRepository->save($log);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    private function hasChanges(?array $originalData, array $newData, bool $isObjectNew): bool
    {
        if ($isObjectNew) {
            return true;
        }

        if ($originalData === null) {
            return true;
        }

        $ignoredKeys = ['updated_at' => true];
        $filteredOriginalData = array_diff_key($originalData, $ignoredKeys);
        $filteredNewData = array_diff_key($newData, $ignoredKeys);

        return $filteredOriginalData != $filteredNewData;
    }
}
