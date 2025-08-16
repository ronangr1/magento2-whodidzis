<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ronangr1\WhoDidZis\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LogSearchResultsInterface extends SearchResultsInterface
{
    public function getItems(): array;

    public function setItems(array $items): static;
}
