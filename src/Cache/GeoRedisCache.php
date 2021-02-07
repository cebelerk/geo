<?php

namespace Geo\Cache;

use Geo\Model\GeoRecord;
use Redis;
use RuntimeException;

/**
 * Class GeoRedisCache
 * @package Geo\Cache
 */
class GeoRedisCache implements GeoCacheInterface
{
    /**
     * @var Redis
     */
    private $cache;

    /**
     * GeoRedisCache constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (empty($options)) {
            throw new RuntimeException('Redis options not initialize.');
        }

        $this->cache = new Redis();
        $this->cache->connect($options['host'], $options['port']);
        $this->cache->auth($options['password']);
    }

    /**
     * @param string $ip
     * @return bool
     */
    public function has(string $ip): bool
    {
        return $this->cache->exists($ip);
    }

    /**
     * @param string $ip
     * @param GeoRecord $value
     */
    public function set(string $ip, GeoRecord $value): void
    {
        $this->cache->set($ip, serialize($value));
    }

    /**
     * @param string $ip
     * @return GeoRecord
     */
    public function get(string $ip): GeoRecord
    {
        return unserialize($this->cache->get($ip), ['allowed_classes' => true]);
    }
}
