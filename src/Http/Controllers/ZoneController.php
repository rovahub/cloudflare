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
        return view('cloudflare::zones.index', compact('zones'));
    }

    public function show($id)
    {
        page_title()->setTitle(__('cloudflare::zone.domain'));
        $zones = Cloudflare::listZones();
        $zones = $zones->result;
        return view('cloudflare::zones.detail', compact('zones'));
    }

    public function cachePurge(Request $request){
        $zones = Cloudflare::cachePurgeEverything($request->input('domain'));
        return $zones;
    }

    public function enable(Request $request){
        return Cloudflare::enableOrDisable($request->input('domain'));
    }
}
