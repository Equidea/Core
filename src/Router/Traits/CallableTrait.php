<?php

namespace Equidea\Router\Traits;

use Equidea\Http\Interfaces\RequestInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Router\Traits
 */
trait CallableTrait {
    
    /**
     * @param   string                                      $classname
     * @param   string                                      $method
     * @param   \Equidea\Http\Interfaces\RequestInterface   $request
     *
     * @return  callable
     */
    public function createCallable($classname, $method, RequestInterface $request)
    {
        // Create new anonymous function which calls controller -> method
        $callable = function() use ($classname, $method, $request) {
            $class = new $classname($request);
            return call_user_func_array([$class, $method], func_get_args());
        };
        return $callable;
    }
}