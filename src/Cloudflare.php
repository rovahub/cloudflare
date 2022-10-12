<?php

namespace Rovahub\Cloudflare;

use Cloudflare\API\Auth\APIKey as CloudflareAPIKey;
use Cloudflare\API\Adapter\Guzzle as CloudflareAdapter;
use Cloudflare\API\Endpoints\Zones as CloudflareZone;

class Cloudflare
{
    private $adapter;
    private $zoneService;

    public function __construct()
    {
        $key = new CloudflareAPIKey(config('cloudflare.email'), config('cloudflare.api'));
        $this->adapter = new CloudflareAdapter($key);
        $this->zoneService = new CloudflareZone($this->adapter);
    }

    public function getZoneDataId($domain)
    {
        $zone = $this->listZones([$domain])->result;
        return $zone[0];
    }

    public function listZones($domains = [], $page = 1)
    {
        $domains = implode(',', $domains);
        return $this->zoneService->listZones($domains, 'active', $page);
    }

    public function cachePurgeEverything($domain)
    {
        $zoneId = $this->getZoneDataId($domain)->id;
        return $this->zoneService->cachePurgeEverything($zoneId);
    }

    public function enableOrDisable($domain)
    {
        $zone = $this->getZoneDataId($domain);
        $paused = $zone->paused;
        if(!$paused){
            return $this->zoneService->pause($zone->id);
        }
        return $this->zoneService->unpause($zone->id);
    }
}
