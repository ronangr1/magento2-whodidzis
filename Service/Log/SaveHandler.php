<?php
/**
 *  * Copyright © Ronangr1. All rights reserved.
 *  * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Service\Log;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Serialize\JsonConverter;
use Psr\Log\LoggerInterface;
use Ronangr1\WhoDidZis\Model\Event\Type;
use Ronangr1\WhoDidZis\Resolver\ActorResolverInterface;
use Ronangr1\WhoDidZis\Api\Data\LogInterfaceFactory;
use Ronangr1\WhoDidZis\Api\LogRepositoryInterface;

class SaveHandler
{

    public function __construct(
        private readonly ActorResolverInterface $actorResolver,
        private readonly LogRepositoryInterface $logRepository,
        private readonly JsonConverter $jsonConverter,
        private readonly LogInterfaceFactory $logFactory,
        private readonly LoggerInterface $logger
    ) {
    }

    public function handle(AbstractModel $object, ?array $originalData, array $newData, bool $isObjectNew): void
    {
        if ($isObjectNew) {
            $eventType = Type::TYPE_CREATED;
        } else {
            if ($originalData === null || $originalData == $newData) {
                return;
            }
            $eventType = Type::TYPE_UPDATED;
        }

        try {
            $log = $this->logFactory->create();

            $actor = $this->actorResolver->getCurrentActor();

            $log->setEntityType(get_class($object));
            $log->setEntityId((int)$object->getId());
            $log->setActorType($actor->getType());
            $log->setActorName($actor->getName());
            $log->setEventType($eventType);

            $beforeJson = $this->jsonConverter->convert($originalData);
            if ($beforeJson === false) {
                throw new \InvalidArgumentException('Failed to encode original data to JSON: ' . json_last_error_msg());
            }

            $log->setBeforeData($beforeJson);

            $afterJson = $this->jsonConverter->convert($newData);
            if ($afterJson === false) {
                throw new \InvalidArgumentException('Failed to encode new data to JSON: ' . json_last_error_msg());
            }
            $log->setAfterData($afterJson);

            $this->logRepository->save($log);
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}
