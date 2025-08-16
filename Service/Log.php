<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Service;

class Log
{
    public function hasChanges(?array $originalData, array $newData, bool $isObjectNew): bool
    {
        if ($isObjectNew) {
            return true;
        }

        if ($originalData === null) {
            return true;
        }

        $ignoredKeys = ['updated_at' => true];
        $filteredOriginalData = array_diff_key($originalData, $ignoredKeys);
        $filteredNewData = array_diff_key($newData, $ignoredKeys);

        return $filteredOriginalData != $filteredNewData;
    }
}
