<?php
/**
 * PEAR2\Templates\Savant\Turbo\Main
 *
 * PHP version 5
 *
 * @category  Yourcategory
 * @package   
 * @author    Your Name <handle@php.net>
 * @copyright 2011 Your Name
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   SVN: $Id$
 * @link      http://svn.php.net/repository/pear2/
 */

/**
 * Main class for 
 *
 * @category  Templates
 * @package   PEAR2_Templates_Savant_Turbo
 * @author    Brett Bieber <saltybeagle@php.net>
 * @copyright 2011 Your Name
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://svn.php.net/repository/pear2/
 */
namespace PEAR2\Templates\Savant\Turbo;
use PEAR2\Templates\Savant;
class Main extends Savant\Main
{
    /**
     * The caching interface.
     * 
     * @var CacheInterface
     */
    protected $cache;
    
    /**
     * Set the cache interface
     * 
     * @param CacheInterface $cache
     */
    public function setCacheInterface(CacheInterface $cache)
    {
        $this->cache = $cache;
    }
    
    /**
     * Get the cache interface
     * 
     * @return CacheInterface
     */
    public function getCacheInterface()
    {
        if (!isset($this->cache)) {
            $this->setCacheInterface(new CacheInterface\CacheLite());
        }
        return $this->cache;
    }

    /**
     * Render an object, and if it is cacheable, cache the output.
     * 
     * @see lib/php/Savvy::renderObject()
     */
    public function renderObject($object, $template = null)
    {
        if ($object instanceof CacheableInterface
            || ($object                    instanceof Savant\ObjectProxy
                && $object->getRawObject() instanceof CacheableInterface)) {
            $key = $object->getCacheKey();

            // We have a valid key to store the output of this object.
            if ($key !== false && $data = $this->getCacheInterface()->get($key)) {
                // Tell the object we have cached data and will output that.
                $object->preRun(true);
            } else {
                // Content should be cached, but none could be found.
                $object->preRun(false);
                $object->run();
                $data = parent::renderObject($object, $template);

                if ($key !== false) {
                    $this->getCacheInterface()->save($data, $key);
                }

            }

            if ($object instanceof PostRunReplacements) {
                $data = $object->postRun($data);
            }

            return $data;
        }

        return parent::renderObject($object, $template);

    }

}
