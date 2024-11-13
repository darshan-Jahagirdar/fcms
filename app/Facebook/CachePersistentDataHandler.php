<?php

namespace App\Facebook;

use Facebook\PersistentData\PersistentDataInterface;
use Illuminate\Cache\CacheManager;

class CachePersistentDataHandler implements PersistentDataInterface
{
    protected $cache;

    public function __construct(CacheManager $cache)
    {
        dump('persistant cache constructor');
        $this->cache = $cache;
    }

    public function get($key)
    {
        dump('persistant cache get');
        if ($value = $this->cache->pull($key)) {
            $this->cache->forget($key);
        }

        return $value;
    }

    public function set($key, $value)
    {
        dump('persistant cache set');
        $this->cache->put($key, $value);
    }
}
