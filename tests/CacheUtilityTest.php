<?php

use PHPUnit\Framework\TestCase;
use App\Utilities\CacheUtility;

class CacheUtilityTest extends TestCase {
    private $cache;

    protected function setUp(): void {
        $this->cache = new CacheUtility();
    }

    public function testCacheSetAndGet() {
        $key = 'articles_epaga';
        $value = 'TEST CACHE';

        $this->cache->set($key, $value);

        $result = $this->cache->get($key);
        $this->assertEquals($value, $result);
    }
}
