<?php

namespace Rovahub\Cloudflare;

use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Cloudflare\API\Auth\APIKey as CloudflareAPIKey;
use Cloudflare\API\Adapter\Guzzle as CloudflareAdapter;
use Cloudflare\API\Endpoints\Zones as CloudflareZone;

class Cloudflare
{
    private $client;
    private $adapter;
    private $zones;

    public function __construct()
    {
        $key = new CloudflareAPIKey(config('cloudflare.email'), config('cloudflare.api'));
        $this->adapter = new CloudflareAdapter($key);
        $this->zones = new CloudflareZone($this->adapter);
    }

    public function listZones($domains = [], $page = 1)
    {
        $domains = implode(',', $domains);
        return $this->zones->listZones($domains, 'active', $page);
    }

    public function cachePurgeEverything($zoneId)
    {
        return $this->zones->cachePurgeEverything($zoneId);
    }

    public function pause($zoneId)
    {
        return $this->zones->pause($zoneId);
    }

    public function unpause($zoneId)
    {
        return $this->zones->unpause($zoneId);
    }
}
