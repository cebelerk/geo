<?php

namespace Geo;

use Geo\Cache\GeoRedisCache;
use Geo\Model\GeoRecord;
use Geo\Provider\IpGeoLocationGeoProvider;
use Geo\Provider\IpInfoGeoProvider;
use Geo\Service\GeoRecordService;
use Geo\Service\GeoService;
use Geo\Service\GeoServiceCached;
use GuzzleHttp\Client;

/**
 * Class Application
 * @package Geo
 */
class Application
{
    /**
     * @var Application
     */
    private static $instance;

    /**
     * @return Application
     */
    public static function getInstance(): Application
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @param array $env
     * @param string|null $ip
     * @return GeoRecord|null
     */
    public function run(array $env, ?string $ip): ?GeoRecord
    {
        if (!$ip) {
            return null;
        }

        $client = new Client();
        $geoRecordService = new GeoRecordService();
        $cache = new GeoRedisCache(
            [
                'host' => $env['REDIS_HOST'],
                'port' => $env['REDIS_PORT'],
                'password' => $env['REDIS_PASSWORD']
            ]
        );

        $geoService = new GeoService(
            [
                new IpGeoLocationGeoProvider($client, $env['IPGEOLOCATION_API_KEY']),
                new IpInfoGeoProvider($client, $env['IPINFO_API_KEY'])
            ],
            $geoRecordService
        );

        $geoServiceCached = new GeoServiceCached($geoService, $cache);

        return $geoServiceCached->getLocation($ip);
    }
}
