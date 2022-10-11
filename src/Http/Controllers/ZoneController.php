<?php

namespace Rovahub\Cloudflare\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Cloudflare;
use Arr;

class ZoneController extends Controller
{
    public function index()
    {
        page_title()->setTitle(__('cloudflare::zone.domain'));
        $zones = Cloudflare::listZones();
        $zones = $zones->result;
        return view('cloudflare::zones', compact('zones'));
    }

    public function cachePurge(Request $request){
        $zones = Cloudflare::cachePurgeEverything($request->input('id'));
        return $zones;
    }

    public function proxies(Request $request){
        if($request->input('pause')){
            return Cloudflare::unpause($request->input('id'));
        }
        return Cloudflare::pause($request->input('id'));
    }
}
