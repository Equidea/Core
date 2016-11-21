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
     * @param   array   $arguments
     *
     * @return  mixed
     */
    public function retrieve(string $name, array $arguments = [])
    {
        $class = $this->services[$name];
        return call_user_func_array($class, $arguments);
    }
}
