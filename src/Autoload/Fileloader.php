<?php

namespace Equidea\Autoload;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @package     Equidea\Autoload
 */
class Fileloader {
    
    /**
     * @param   string  $file
     *
     * @return  boolean
     */
    public static function loadFile($file)
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
    public static function getFileContent($file)
    {
        if (file_exists($file)) {
            return include($file);
        }
    }
}