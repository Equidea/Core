<?php

namespace Equidea\Autoload;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Autoload
 */
class Fileloader {
    
    /**
     * @param   string  $file
     *
     * @return  boolean
     */
    public static function loadFile(string $file):bool
    {
        $exists = file_exists($file);
        
        if ($exists) {
            require $file;
        }
        
        return $exists;
    }
    
    /**
     * @param   string  $file
     *
     * @return  mixed
     */
    public static function getFileContent(string $file)
    {
        if (file_exists($file)) {
            return include($file);
        }
    }
}