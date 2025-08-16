<?php

/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class LogActions extends Column
{
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
                    ];
                }
            }
        }

        return $dataSource;
    }
}

