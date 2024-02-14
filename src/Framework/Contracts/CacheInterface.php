<?php

namespace Framework\Contracts;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class CacheInterface implements CacheItemPoolInterface
{
    /** @var array */
    private $cache = [];

    /**
     * @inheritDoc
     */
    public function getItem($key): CacheItemInterface
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('Klíč musí být řetězec.');
        }

        if (!array_key_exists($key, $this->cache)) {
            $this->cache[$key] = new MyCacheItem($key);
        }

        return $this->cache[$key];
    }

    /**
     * @inheritDoc
     */
    public function getItems(array $keys = []): iterable
    {
        $items = [];
        foreach ($keys as $key) {
            $items[] = $this->getItem($key);
        }

        return $items;
    }

    /**
     * @inheritDoc
     */
    public function hasItem($key): bool
    {
        return isset($this->cache[$key]);
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        $this->cache = [];
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteItem($key): bool
    {
        unset($this->cache[$key]);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteItems(array $keys): bool
    {
        foreach ($keys as $key) {
            unset($this->cache[$key]);
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function save(CacheItemInterface $item): bool
    {
        $key = $item->getKey();
        $value = $item->get();

        $this->cache[$key] = $value;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function saveDeferred(CacheItemInterface $item): bool
    {
        // V našem jednoduchém příkladu nemusíme řešit odklad ukládání.
        return $this->save($item);
    }

    /**
     * @inheritDoc
     */
    public function commit(): bool
    {
        // V našem jednoduchém příkladu nemusíme řešit commit.
        return true;
    }
}
