<?php

namespace Equidea;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea
 */
class Autoloader {
    
    /**
     * @var array
     */
    private $prefixes = [];
    
    /**
     * Starts the autoloader. Should be called only after all prefixes
     * were added to the internal array with Autoloader::addNamespace()
     *
     * @return  void
     */
    public function register() {
        spl_autoload_register([$this, 'loadClass']);
    }
    
    /**
     * Adds a namespace prefix and its associated path to the internal array,
     * e.g. Equidea\\ => ../src/
     *
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
     * The function to be used by spl_autoload_register. It checks the current
     * classname for an existing namespace prefix. If a matching prefix was found,
     * the class will be loaded.
     *
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
     * Loads a class by putting together the path to its file
     * 
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
        return $this->loadFile($file);
    }
    
    /**
     * As its name suggests, this function loads a file
     *
     * @param   string  $file
     *
     * @return  boolean
     */
    public function loadFile(string $file):bool
    {
        // Checks the required file for its existance
        $exists = file_exists($file);
        
        // If it does exist, load it
        if (file_exists($file)) {
            require $file;
        }
        
        // Return if loading the file was a success
        return $exists;
    }
}