<?php

namespace Rovahub\Cloudflare\Http\Controllers;

use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function signin()
    {
        return view('cloudflare::index');
    }
}
