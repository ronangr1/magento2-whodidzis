<?php

/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class LogActions extends Column
{
    private const URL_PATH_REVERT = 'configrecord/configrecord/revert';

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        protected UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['log_id'])) {
                    $item[$this->getData('name')] = [
                        $item['log_id'] => [
                            'label' => __('Show Changes'),
                            'callback' => [
                                'provider' => 'ronangr1_whodidzis_log_listing.ronangr1_whodidzis_log_listing.ronangr1_whodidzis_log_columns.log_actions',
                                'target' => 'openChanges',
                            ],
                        ],
                        'revert' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_REVERT,
                                [
                                    'entity_id' => $item['log_id']
                                ]
                            ),
                            'label' => __('Revert'),
                            'confirm' => [
                                'title' => __('Revert'),
                                'message' => __('Are you sure you wan\'t to revert this record?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}

