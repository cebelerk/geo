<?php

namespace Geo\Model;

/**
 * Class GeoRecord
 * @package Geo\Model
 */
class GeoRecord
{
    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $region;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return GeoRecord
     */
    public function setCity(?string $city): GeoRecord
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string|null $region
     * @return GeoRecord
     */
    public function setRegion(?string $region): GeoRecord
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return GeoRecord
     */
    public function setCountry(?string $country): GeoRecord
    {
        $this->country = $country;

        return $this;
    }
}
