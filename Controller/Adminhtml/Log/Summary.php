<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Controller\Adminhtml\Log;

use Exception;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;
use Ronangr1\WhoDidZis\Api\LogRepositoryInterface;

class Summary implements HttpGetActionInterface, CsrfAwareActionInterface
{
    public function __construct(
        private readonly JsonFactory $jsonResultFactory,
        private readonly RequestInterface $request,
        private readonly LoggerInterface $logger,
        private readonly LogRepositoryInterface $logRepository,
    ) {
    }

    public function execute()
    {
        $result = $this->jsonResultFactory->create();
        $result->setData(['success' => false]);
        $params = $this->request->getParams();
        if ($params) {
            try {
                $log = $this->logRepository->get($params['id']);
                $data = json_decode($log->getChangesSummary(), true);
                $result->setData([
                    'success' => true,
                    'data' => $data
                ]);
            } catch (Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }

        return $result;
    }

    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
