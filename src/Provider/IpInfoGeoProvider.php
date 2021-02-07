<?php

namespace Geo\Provider;

use Geo\Model\GeoRecord;
use RuntimeException;

/**
 * Class IpInfoGeoProvider
 * @package Geo\Provider
 */
class IpInfoGeoProvider extends AbstractGeoProvider implements GeoProviderInterface
{
    public const BASE_URL = 'https://ipinfo.io/%s?token=%s';

    /**
     * @param string $ip
     * @return string
     */
    protected function getPath(string $ip): string
    {
        return sprintf(self::BASE_URL, $ip, $this->apiKey);
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
            ->setCountry($this->getValue($data['country']))
            ->setRegion($this->getValue($data['region']));

        return $record;
    }
}
