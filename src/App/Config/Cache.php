<?php
declare(strict_types=1);

namespace App\Config;

use Symfony\Component\Cache\Adapter\RedisAdapter;

class Cache
{

    public function __construct()
    {

    }

    public function cacheConnection()
    {
        // Připojení k Redis serveru
        $redisConnection = [
            'host' => '127.0.0.1',
            'port' => 6379,
            'timeout' => 0.1, // volitelné, nastaví timeout na 100 milisekund
        ];

        $cachePool = RedisAdapter::createConnection($string,$redisConnection)
            ->createCachePool();

        return $cachePool;
}
}