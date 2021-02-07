<?php

namespace Geo\Provider;

use Geo\Model\GeoRecord;

/**
 * Interface GeoProviderInterface
 * @package Geo\Provider
 */
interface GeoProviderInterface
{
    /**
     * @param string $ip
     * @return GeoRecord|null
     */
    public function getRecord(string $ip): ?GeoRecord;
}
