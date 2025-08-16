<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Service\Log;

use Exception;
use Magento\Framework\Model\AbstractModel;
use Psr\Log\LoggerInterface;
use Ronangr1\WhoDidZis\Api\Data\LogInterfaceFactory;
use Ronangr1\WhoDidZis\Api\LogRepositoryInterface;
use Ronangr1\WhoDidZis\Model\Event\Type;
use Ronangr1\WhoDidZis\Resolver\ActorResolverInterface;
use Ronangr1\WhoDidZis\Service\Log as LogService;

class SaveHandler
{

    public function __construct(
        private readonly ActorResolverInterface $actorResolver,
        private readonly LogRepositoryInterface $logRepository,
        private readonly LogInterfaceFactory $logFactory,
        private readonly LoggerInterface $logger,
        private readonly FormatterHandler $formatterHandler,
        private readonly LogService $logService,
        private readonly array $deniedEntityTypes = [],
    ) {
    }

    public function handle(AbstractModel $object, ?array $originalData, array $newData, bool $isObjectNew): void
    {
        if (!$this->logService->hasChanges($originalData, $newData, $isObjectNew)) {
            return;
        }

        $entityType = get_class($object);
        if (str_contains($entityType, 'Interceptor')) {
            $entityType = get_parent_class($entityType);
        }

        if (in_array($entityType, $this->deniedEntityTypes)) {
            return;
        }

        $formatter = $this->formatterHandler->getFormatterForEntity($entityType);
        $logContent = $formatter->format($object, $originalData ?? [], $newData);

        if ($logContent === null) {
            return;
        }

        try {
            $actor = $this->actorResolver->getCurrentActor();
            $log = $this->logFactory->create();
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
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
