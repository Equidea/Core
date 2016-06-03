<?php

namespace Equidea\View;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Database
 */
class View {
    
    /**
     * @var string
     */
    public static $path = '../app/views/';
    
    /**
     * @var string
     */
    public static $extension = '.php';
    
    /**
     * @param   string  $path
     * @param   string  $extension
     *
     * @return  void
     */
    public static function configure($path, $extension)
    {
        self::$path = $path;
        self::$extension = $extension;
    }
    
    /**
     * @param   string  $name
     * @param   array   $data
     *
     * @return  string
     */
    public static function render($name, $data = [])
    {
        $template = new Template(self::$path, $name, self::$extension, $data);
        return $template->render();
    }
}