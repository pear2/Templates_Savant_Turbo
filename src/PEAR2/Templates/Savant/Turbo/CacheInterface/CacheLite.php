<?php

namespace PEAR2\Templates\Savant\Turbo\CacheInterface;

use PEAR2\Templates\Savant\Turbo\CacheInterface;
use PEAR2\Templates\Savant\Turbo;

class CacheLite implements CacheInterface
{
    /**
     * Cache_Lite object
     * 
     * @var Cache_Lite
     */
    protected $cache;

    public $options = array('lifeTime'=>3600);

    public $group;

    /**
     * Constructor
     */
    function __construct($options = array())
    {
        $this->options = $options + $this->options;
        $this->cache = new \PEAR2\Cache\Lite\Main($this->options);
    }
    
    /**
     * Get an item stored in the cache
     * 
     * @see CacheInterface#get()
     */
    function get($key)
    {
        return $this->cache->get($key, $this->group);
    }
    
    /**
     * Save an element to the cache
     * 
     * @see CacheInterface#save()
     */
    function save($data, $key)
    {
        return $this->cache->save($data, $key, $this->group);
    }
}