<?php
require_once __DIR__ . '/../vendor/php/PEAR2/Autoload.php';
PEAR2\Autoload::initialize(__DIR__ . '/../src');

use PEAR2\Templates\Savant;

/**
 * Instead of constructing a Savant\Main object, construct a
 * Savant\Turbo method.
 * 
 * @var \PEAR2\Templates\Savant\Turbo\Main
 */
$savant = new Savant\Turbo\Main();

/**
 * The following line is optional, but can be called if you need to customize
 * the Cache_Lite settings.
 * 
 * For testing on development machines, you can use a Mock caching driver:
 * $savant->setCacheInterface(new Savant\Turbo\CacheInterface\Mock());
 */
$savant->setCacheInterface(new Savant\Turbo\CacheInterface\CacheLite());


/**
 * Construct your object that implements CacheableInterface
 * 
 * @see \PEAR2\Templates\Savant\Turbo\CacheableInterface
 * @var Foo
 */

class CacheableObject implements Savant\Turbo\CacheableInterface
{

    /**
     * Return a unique caching key for this object
     * 
     * @return string
     */
    function getCacheKey()
    {
        return 'Foo object with ID#1';
    }

    /**
     * This method is always called before any output is sent
     *
     * @param bool $cached
     */
    function preRun($cached)
    {
        if ($cached) {
            // cached output is about to be sent
        }
        // No cached output was available

        // Set any headers that need to be sent etc
    }

    /**
     * When non-cached output is sent, this method will be called
     */
    function run()
    {

    }
}

$cacheableObject = new CacheableObject;

echo $savant->render($cacheableObject);
