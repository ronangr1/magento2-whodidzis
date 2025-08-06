<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Observer;

use Magento\Config\Model\Config;
use Magento\Config\Model\Config\Structure as ConfigStructure;
use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory as ConfigCollectionFactory;
use Magento\Config\Model\ConfigFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Ronangr1\WhoDidZis\Api\Data\LogInterfaceFactory;
use Ronangr1\WhoDidZis\Api\LogRepositoryInterface;
use Ronangr1\WhoDidZis\Model\Event\Type;
use Ronangr1\WhoDidZis\Resolver\ActorResolver;
use Ronangr1\WhoDidZis\Service\Log\FormatterHandler;

class ConfigChangeObserver implements ObserverInterface
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly ConfigCollectionFactory $configCollectionFactory,
        private readonly ConfigFactory $configFactory,
        private readonly LogRepositoryInterface $logRepository,
        private readonly LogInterfaceFactory $logFactory,
        private readonly FormatterHandler $formatterHandler,
        private readonly ActorResolver $actorResolver,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function execute(Observer $observer)
    {
        /** @var array $configData */
        $configData = $observer->getData('configData');
        if (empty($configData['section']) || empty($configData['groups'])) {
            return;
        }

        $newData = [];
        $section = $configData['section'];
        $this->flattenConfigGroups($newData, $configData['groups'], $section);

        if (empty($newData)) {
            $this->logger->info('[WhoDidZis] No new data found after flattening.');
            return;
        }

        $scope = 'default';
        $scopeId = 0;
        if (!empty($configData['store'])) {
            $scope = 'stores';
            $scopeId = $configData['store'];
        } elseif (!empty($configData['website'])) {
            $scope = 'websites';
            $scopeId = $configData['website'];
        }


        $configCollection = $this->configCollectionFactory->create();
        $configCollection->addFieldToFilter('scope', $scope);
        $configCollection->addFieldToFilter('scope_id', $scopeId);
        $configCollection->addFieldToFilter('path', ['in' => array_keys($newData)]);

        $originalData = [];
        foreach ($configCollection as $item) {
            $originalData[$item->getPath()] = $item->getValue();
        }

        /** @var \Magento\Config\Model\Config $object */
        $object = $this->configFactory->create();
        $object->setSection($section);
        $object->setWebsite($this->request->getParam('website'));
        $object->setStore($this->request->getParam('store'));

        $entityType = Config::class;
        $formatter = $this->formatterHandler->getFormatterForEntity($entityType);

        $logContent = $formatter->format($object, $originalData, $newData);

        if (empty($logContent)) {
            return;
        }

        try {
            $log = $this->logFactory->create();
            $actor = $this->actorResolver->getCurrentActor();
            $log->setEntityType($entityType);
            $log->setActorType($actor->getType());
            $log->setActorName($actor->getName());
            $log->setEventType(Type::TYPE_UPDATED);
            $log->setChangesSummary($logContent);
            $this->logRepository->save($log);
        } catch (\Exception $e) {
            $this->logger->critical('[WhoDidZis] Failed to log config change: ' . $e->getMessage());
        }
    }

    private function flattenConfigGroups(array &$result, array $groups, string $pathPrefix): void
    {
        foreach ($groups as $groupName => $groupData) {
            $currentPath = $pathPrefix . '/' . $groupName;
            if (isset($groupData['fields'])) {
                foreach ($groupData['fields'] as $fieldName => $fieldData) {
                    if (isset($fieldData['value'])) {
                        $result[$currentPath . '/' . $fieldName] = $fieldData['value'];
                    }
                }
            }
            if (isset($groupData['groups'])) {
                $this->flattenConfigGroups($result, $groupData['groups'], $currentPath);
            }
        }
    }
}
