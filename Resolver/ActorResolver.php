<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Resolver;

use Magento\Authorization\Model\UserContextInterface;
use Magento\Backend\Model\Auth\Session as BackendSession;
use Magento\Framework\App\Area;
use Magento\Framework\App\State as AppState;
use Magento\Framework\DataObject;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\Exception\IntegrationException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Api\IntegrationServiceInterface;
use Psr\Log\LoggerInterface;
use Ronangr1\WhoDidZis\Model\Actor\Type;

class ActorResolver implements ActorResolverInterface
{
    public function __construct(
        private readonly AppState $appState,
        private readonly UserContextInterface $userContext,
        private readonly BackendSession $backendSession,
        private readonly DataObjectFactory $dataObjectFactory,
        private readonly IntegrationServiceInterface $integrationService,
        private readonly LoggerInterface $logger,
        private ?DataObject $actor = null,
    ) {
    }

    public function getCurrentActor(): DataObject
    {
        if ($this->actor !== null) {
            return $this->actor;
        }

        try {
            $areaCode = $this->appState->getAreaCode();
        } catch (LocalizedException $e) {
            $this->logger->critical($e->getMessage());
            $areaCode = 'cli';
        }

        $userId = $this->userContext->getUserId();
        $userType = $this->userContext->getUserType();

        if ($areaCode === Area::AREA_CRONTAB) {
            return $this->actor = $this->createActor(Type::CRON);
        }

        if ($userType === UserContextInterface::USER_TYPE_INTEGRATION) {
            $actorName = $this->getIntegrationName((int)$userId);
            return $this->actor = $this->createActor(Type::API, (int)$userId, $actorName);
        }

        if ($userType === UserContextInterface::USER_TYPE_ADMIN) {
            $actorName = $this->backendSession->getUser() ? $this->backendSession->getUser()->getUserName(
            ) : 'Unknown Admin';
            return $this->actor = $this->createActor(Type::ADMIN, (int)$userId, $actorName);
        }

        if ($userType === UserContextInterface::USER_TYPE_CUSTOMER) {
            return $this->actor = $this->createActor(Type::CUSTOMER, (int)$userId);
        }

        $actorName = php_sapi_name() === 'cli' ? Type::CLI_COMMAND : Type::SYSTEM;
        return $this->actor = $this->createActor($actorName);
    }

    private function createActor(string $type, ?int $id = null, ?string $name = null): DataObject
    {
        return $this->dataObjectFactory->create([
            'data' => [
                'type' => $type,
                'id' => $id,
                'name' => $name ?? $type
            ]
        ]);
    }

    private function getIntegrationName(int $integrationId): string
    {
        try {
            $integration = $this->integrationService->get($integrationId);
            return $integration->getName();
        } catch (IntegrationException $e) {
            $this->logger->debug($e->getMessage());
            return 'Unknown Integration';
        }
    }
}
