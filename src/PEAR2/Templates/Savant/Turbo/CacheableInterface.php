<?php
/**
 * Interface cacheable objects must implement.
 * 
 * @author bbieber
 */
namespace PEAR2\Templates\Savant\Turbo;

interface CacheableInterface
{
    public function getCacheKey();
    public function run();
    public function preRun($cached);
}
