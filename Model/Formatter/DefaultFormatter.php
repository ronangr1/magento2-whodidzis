<?php
/**
 * Copyright © Ronangr1. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Ronangr1\WhoDidZis\Model\Formatter;

use DateTimeInterface;
use Magento\Framework\Serialize\SerializerInterface;

class DefaultFormatter implements FormatterInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly array $ignoredKeys = [],
    ) {
    }

    public function format($object, array $originalData, array $newData): ?string
    {
        $ignoredKeys = $this->ignoredKeys;

        $filteredOriginalData = array_diff_key($originalData, $ignoredKeys);
        $filteredNewData = array_diff_key($newData, $ignoredKeys);

        // Array conversion
        $filteredOriginalData = self::stringifyArrayValues($filteredOriginalData);
        $filteredNewData = self::stringifyArrayValues($filteredNewData);

        // DateTime conversion
        $filteredOriginalData = self::stringifyDateTimes($filteredOriginalData);
        $filteredNewData = self::stringifyDateTimes($filteredNewData);

        $diff = array_diff_assoc($filteredNewData, $filteredOriginalData);

        if (empty($diff)) {
            return null;
        }

        return $this->serializer->serialize($diff);
    }

    private static function stringifyArrayValues(array $data): array
    {
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $data[$k] = json_encode($v);
            }
        }
        return $data;
    }

    private static function stringifyDateTimes(array $data): array
    {
        foreach ($data as $k => $v) {
            if ($v instanceof DateTimeInterface) {
                $data[$k] = $v->format(DATE_ATOM);
            }
        }
        return $data;
    }
}
