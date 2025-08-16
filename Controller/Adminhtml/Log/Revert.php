<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1); 

namespace Ronangr1\WhoDidZis\Controller\Adminhtml\Log;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\Controller\ResultInterface;
use Ronangr1\WhoDidZis\Api\LogRepositoryInterface;
use Ronangr1\WhoDidZis\Service\Cache;

class Revert extends Action
{
    public function __construct(
        private readonly LogRepositoryInterface $configRecordRepository,
        private readonly WriterInterface $writer,
        private readonly Cache $cache,
        Context $context
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                $log = $this->configRecordRepository->get($id);
                if ($log->getEntityId()) {
                    $this->writer->save(
                        $log->getPath(),
                        $log->getOldValue(),
                        $log->getScope()
                    );
                    $this->configRecordRepository->delete($log);
                    $this->cache->clean();
                    $this->messageManager->addSuccessMessage(__('You reverted the record.'));
                }
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a record to revert.'));
        return $resultRedirect->setPath('*/*/');
    }
}

