<?php

namespace Rovahub\Cloudflare\Supports;

class Title
{
    protected $title;

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle($full = true)
    {
        if (empty($this->title)) {
            return config('cloudflare.name');
        }

        if (!$full) {
            return $this->title;
        }

        return $this->title . ' | ' . config('cloudflare.name');
    }

}
