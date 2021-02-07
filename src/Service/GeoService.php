<?php

namespace Geo\Service;

use Geo\Model\GeoRecord;
use Geo\Provider\GeoProviderInterface;

/**
 * Class GeoService
 * @package Geo\Service
 */
class GeoService
{
    /**
     * @var GeoProviderInterface[]
     */
    private $providers;

    /**
     * @var GeoRecordService
     */
    private $geoRecordService;

    /**
     * GeoService constructor.
     * @param array $providers
     * @param GeoRecordService $geoRecordService
     */
    public function __construct(array $providers, GeoRecordService $geoRecordService)
    {
        $this->providers = $providers;
        $this->geoRecordService = $geoRecordService;
    }

    /**
     * @param GeoProviderInterface $provider
     */
    private function addProvider(GeoProviderInterface $provider): void
    {
        if (!isset($this->providers[get_class($provider)])) {
            $this->providers[get_class($provider)] = $provider;
        }
    }

    /**
     * @param string $ip
     * @return GeoRecord|null
     */
    public function getLocation(string $ip): ?GeoRecord
    {
        if (!count($this->providers)) {
            return null;
        }

        $results = $this->getProvidersResult($ip);

        if (!count($results)) {
            return null;
        }

        return $results[0];
    }

    /**
     * @param string $ip
     * @return array
     */
    private function getProvidersResult(string $ip): array
    {
        $results = [];
        foreach ($this->providers as $provider) {
            $results[] = $provider->getRecord($ip);
        }

        usort(
            $results,
            function ($a, $b) {
                $precisionA = $this->geoRecordService->getPrecision($a);
                $precisionB = $this->geoRecordService->getPrecision($b);

                if ($precisionA === $precisionB) {
                    return 0;
                }

                return ($precisionA < $precisionB) ? 1 : -1;
            }
        );

        return $results;
    }
}
