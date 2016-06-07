<?php

namespace Equidea\Autoload;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Autoload
 */
class Autoloader {
    
    /**
     * @var array
     */
    private $prefixes = [];
    
    /**
     * @return  void
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }
    
    /**
     * @param   string  $prefix
     * @param   string  $path
     *
     * @return  void
     */
    public function addNamespace($prefix, $path)
    {
        $prefix = trim($prefix, '\\').'\\';
        $this->prefixes[$prefix] = rtrim($path, '/').'/';
    }
    
    /**
     * @param   string  $class
     *
     * @return  boolean
     */
    private function loadClass($class)
    {
        $prefixes = array_keys($this->prefixes);
        
        foreach ($prefixes as $prefix)
        {
            if (0 === strpos($class, $prefix)) {
                return $this->loadMappedFile($prefix, $class);
            }
        }
        
        return false;
    }
    
    /**
     * @param   string  $prefix
     * @param   string  $class
     *
     * @return  boolean
     */
    private function loadMappedFile($prefix, $class)
    {
        $path = $this->prefixes[$prefix];
        $class = substr($class, strlen($prefix));
        
        $file = $path.str_replace('\\', '/', $class).'.php';
        
        return Fileloader::loadFile($file);
    }
}