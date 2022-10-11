<?php

namespace Rovahub\Cloudflare\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        page_title()->setTitle(__('cloudflare::sidebar.dashboard'));
        return view('cloudflare::index');
    }
}
