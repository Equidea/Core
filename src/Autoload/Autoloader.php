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
    public function register() {
        spl_autoload_register([$this, 'loadClass']);
    }
    
    /**
     * @param   string  $prefix
     * @param   string  $path
     *
     * @return  void
     */
    public function addNamespace(string $prefix, string $path)
    {
        // Delete backslash from beginning, keep or add it at the end
        $prefix = trim($prefix, '\\').'\\';
        // Delete slash from beginning, keep or at it at the end
        $this->prefixes[$prefix] = rtrim($path, '/').'/';
    }
    
    /**
     * @param   string  $class
     *
     * @return  boolean
     */
    private function loadClass(string $class):bool
    {
        // Gets an array of all namespace prefixes
        $prefixes = array_keys($this->prefixes);
        
        // Checks the array of prefixes against the current namespace prefix
        foreach ($prefixes as $prefix)
        {
            // Checks if the beginning of the classname matches the prefix
            if (0 === strpos($class, $prefix)) {
                // If it does, load the file of the matched class
                return $this->loadMappedFile($prefix, $class);
            }
        }
        
        // If none where a match, return false
        return false;
    }
    
    /**
     * @param   string  $prefix
     * @param   string  $class
     *
     * @return  boolean
     */
    private function loadMappedFile(string $prefix, string $class):bool
    {
        // Get the path linked to the namspace prefix
        $path = $this->prefixes[$prefix];
        // Then get the filename by stripping the prefix from it
        $class = substr($class, strlen($prefix));
        
        // Put together the full path to the class
        $file = $path.str_replace('\\', '/', $class).'.php';
        
        // Load the classfile and return it's content
        return Fileloader::loadFile($file);
    }
}