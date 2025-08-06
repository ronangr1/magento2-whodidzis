<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model\Formatter;

class DefaultFormatter implements FormatterInterface
{
    public function format($object, array $originalData, array $newData): ?string
    {
        $ignoredKeys = ['updated_at' => true];
        $filteredOriginalData = array_diff_key($originalData, $ignoredKeys);
        $filteredNewData = array_diff_key($newData, $ignoredKeys);

        $diff = array_diff_assoc($filteredNewData, $filteredOriginalData);

        if (empty($diff)) {
            return null;
        }

        return json_encode($diff, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
