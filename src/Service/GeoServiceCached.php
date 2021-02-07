<?php

namespace Geo\Service;

use Geo\Cache\GeoCacheInterface;
use Geo\Model\GeoRecord;

/**
 * Class GeoServiceCached
 * @package Geo\Service
 */
class GeoServiceCached
{
    /**
     * @var GeoService
     */
    private $geoService;

    /**
     * @var GeoCacheInterface
     */
    private $cache;

    /**
     * GeoService constructor.
     * @param GeoService $geoService
     * @param GeoCacheInterface $cache
     */
    public function __construct(GeoService $geoService, GeoCacheInterface $cache)
    {
        $this->geoService = $geoService;
        $this->cache = $cache;
    }

    /**
     * @param string $ip
     * @return GeoRecord|null
     */
    public function getLocation(string $ip): ?GeoRecord
    {
        if ($this->cache->has($ip)) {
            return $this->cache->get($ip);
        }

        $result = $this->geoService->getLocation($ip);
        if ($result) {
            $this->cache->set($ip, $result);
        }

        return $result;
    }
}
