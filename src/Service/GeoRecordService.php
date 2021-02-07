<?php

namespace Geo\Service;

use Geo\Model\GeoRecord;

/**
 * Class GeoRecordService
 * @package Geo\Service
 */
class GeoRecordService
{
    /**
     * @var array
     */
    private static $fieldWeights = [
        'country' => 1,
        'region' => 2,
        'city' => 4
    ];

    /**
     * @param GeoRecord|null $record
     * @return int
     */
    public function getPrecision(?GeoRecord $record): int
    {
        if ($record === null) {
            return 0;
        }

        $precision = 0;
        foreach (self::$fieldWeights as $field => $weight) {
            $getter = 'get' . $field;
            $result = $record->$getter();

            if ($result) {
                $precision += $weight;
            }
        }

        return $precision;
    }
}
