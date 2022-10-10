<?php

namespace Rovahub\Cloudflare\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'cloudflare_clients';

    protected $primaryKey = 'cloudflare_client_id';

    protected $fillable = [

    ];

}
