<?php

namespace App\Utilities;

class CacheUtility {
    private $memcache;

    public function __construct() {
        $this->memcache = new \Memcached();
    }

    public function get($key) {
        return $this->memcache->get($key);
    }

    public function set($key, $value, $expiration = 3600) {
        return $this->memcache->set($key, $value, $expiration);
    }
}
