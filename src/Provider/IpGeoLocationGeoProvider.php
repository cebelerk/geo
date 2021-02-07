<?php

namespace Geo\Provider;

use Geo\Model\GeoRecord;
use RuntimeException;

/**
 * Class IpGeoLocationGeoProvider
 * @package Geo\Provider
 */
class IpGeoLocationGeoProvider extends AbstractGeoProvider implements GeoProviderInterface
{
    public const BASE_URL = 'https://api.ipgeolocation.io/ipgeo?apiKey=%s&ip=%s';

    /**
     * @param string $ip
     * @return string
     */
    protected function getPath(string $ip): string
    {
        return sprintf(self::BASE_URL, $this->apiKey, $ip);
    }

    /**
     * @param string $ip
     * @return GeoRecord|null
     */
    public function getRecord(string $ip): ?GeoRecord
    {
        try {
            $data = json_decode($this->getData($ip), true);
        } catch (RuntimeException $e) {
            return null;
        }

        $record = new GeoRecord();
        $record
            ->setCity($this->getValue($data['city']))
            ->setCountry($this->getValue($data['country_name']))
            ->setRegion($this->getValue($data['state_prov']));

        return $record;
    }
}
