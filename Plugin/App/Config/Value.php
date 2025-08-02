<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Plugin\App\Config;

use Magento\Backend\Model\Auth\Session;
use Psr\Log\LoggerInterface;
use Ronangr1\WhoDidZis\Service\System\Config\Record;

class Value
{
    public function __construct(
        private readonly Session $authSession,
        private readonly Record $recordService,
        private readonly LoggerInterface $logger
    ) {
    }

    public function afterIsValueChanged(\Magento\Framework\App\Config\Value $subject, $result): void
    {
        if ($result) {
            try {
                $user = $this->authSession->getUser();
                if ($user->getId()) {
                    if ($subject->getOldValue()) {
                        $this->recordService->record([
                            "author" => sprintf("%s (%s)", $user->getName(), $user->getEmail()),
                            "path" => $subject->getPath(),
                            "scope" => $subject->getScope(),
                            "old_value" => $subject->getOldValue(),
                            "new_value" => $subject->getValue()
                        ]);
                    }
                }
            } catch (\Exception $e) {
                $this->logger->debug($e->getMessage());
            }
        }
    }
}
