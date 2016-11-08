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
    private $services = [];
    
    /**
     * @param   string      $name
     * @param   callable    $service
     *
     * @return  void
     */
    public function register(string $name, callable $service) {
        $this->services[$name] = $service;
    }
    
    /**
     * @param   string  $name
     *
     * @return  mixed
     */
    public static function retrieve(string $name)
    {
        $class = $this->services[$name];
        return call_user_func($class);
    }
}