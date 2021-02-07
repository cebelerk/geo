<?php

namespace Geo\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

/**
 * Class AbstractGeoProvider
 * @package Geo\Provider
 */
abstract class AbstractGeoProvider
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var Client
     */
    private $client;

    /**
     * AbstractGeoProvider constructor.
     * @param Client $client
     * @param string $apiKey
     */
    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $ip
     * @return string|null
     */
    protected function getPath(string $ip): ?string
    {
        return null;
    }

    /**
     * @param string $ip
     * @return string
     */
    protected function getData(string $ip): string
    {
        try {
            return $this->client->get($this->getPath($ip))->getBody()->getContents();
        } catch (GuzzleException $exception) {
            throw new RuntimeException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param $value
     * @return string|null
     */
    protected function getValue($value): ?string
    {
        return !empty($value) ? $value : null;
    }
}
