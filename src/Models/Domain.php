<?php

namespace Rovahub\Cloudflare\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table = 'cloudflare_domains';

    protected $primaryKey = 'cloudflare_domain_id';

    protected $fillable = [
        
    ];
}
