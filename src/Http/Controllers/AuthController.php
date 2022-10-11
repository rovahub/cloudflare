<?php

namespace Rovahub\Cloudflare\Http\Controllers;

use Illuminate\Routing\Controller;
use Cloudflare;

class AuthController extends Controller
{
    public function signin()
    {
        $cloudflare = Cloudflare::listZones(['azibai.org']);
        dd($cloudflare);
        return view('cloudflare::index');
    }
}
