<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Service\Log;

use Ronangr1\WhoDidZis\Model\Formatter\FormatterInterface;

class FormatterHandler
{
    public function __construct(
        private readonly array $formatters = []
    ) {
    }

    public function getFormatterForEntity(string $entityType): FormatterInterface
    {
        if (isset($this->formatters[$entityType])) {
            return $this->formatters[$entityType];
        }

        return $this->formatters['default'];
    }
}
