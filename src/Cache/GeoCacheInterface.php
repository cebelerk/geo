<?php

namespace Geo\Cache;

use Geo\Model\GeoRecord;

/**
 * Interface GeoCacheInterface
 * @package Geo\Cache
 */
interface GeoCacheInterface
{
    /**
     * @param string $ip
     * @return boolean
     */
    public function has(string $ip): bool;

    /**
     * @param string $ip
     * @param GeoRecord $value
     */
    public function set(string $ip, GeoRecord $value): void;

    /**
     * @param string $ip
     * @return GeoRecord
     */
    public function get(string $ip): GeoRecord;
}