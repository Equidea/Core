<?php

namespace Equidea\Container;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Container
 */
class ServiceContainer {
    
    /**
     * @var array
     */
    private static $services = [];
    
    /**
     * @param   string      $name
     * @param   callable    $service
     *
     * @return  void
     */
    public static function register(string $name, callable $service) {
        self::$services[$name] = $service;
    }
    
    /**
     * @param   string  $name
     *
     * @return  mixed
     */
    public static function retrieve(string $name)
    {
        $class = self::$services[$name];
        return call_user_func($class);
    }
}