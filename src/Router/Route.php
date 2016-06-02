<?php

namespace Equidea\Router;

use Equidea\Http\Request;
use Equidea\Router\Traits\CallableTrait;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Router
 */
class Route {
    
    use CallableTrait;

    /**
     * @var \Equidea\Http\Request
     */
    private $request;
    
    /**
     * @var string
     */
    private $pattern;
    
    /**
     * @var array
     */
    private $controller;
    
    /**
     * @var array
     */
    private $methods = [];
    
    /**
     * @var array|null
     */
    private $guard = null;
    
    /**
     * @var string|null
     */
    private $redirect = null;
    
    /**
     * @param   \Equidea\Http\Request   $request
     * @param   string                  $pattern
     * @param   array                   $controller
     * @param   array                   $methods
     */
    public function __construct(Request $request, $pattern, array $controller, array $methods)
    {
        $this->request = $request;
        $this->setPattern($pattern);
        $this->setController($controller);
        $this->setMethods($methods);
    }
    
    /**
     * @return  string
     */
    public function getPattern() {
        return $this->pattern;
    }
    
    /**
     * @param   string  $pattern
     *
     * @return  void
     */
    public function setPattern($pattern) {
        $this->pattern = '/'.trim($pattern, '/');
    }
    
    /**
     * @return  array
     */
    public function getMethods() {
        return $this->methods;
    }
    
    /**
     * @param   array   $methods
     *
     * @return  void
     */
    public function setMethods(array $methods) {
        $this->methods = $methods;
    }
    
    /**
     * @return  callable
     */
    public function getController()
    {
        // Add the namespace prefix for the controller classes to the classname
        $classname = '\\Equidea\\Controller\\'.$this->controller[0];
        return $this->createCallable($classname, $this->controller[1], $this->request);
    }
    
    /**
     * @param   array   $controller
     *
     * @return  void
     */
    public function setController(array $controller) {
        $this->controller = $controller;
    }
    
    /**
     * @return  boolean
     */
    public function hasGuard() {
        return !is_null($this->guard);
    }
    
    /**
     * @return  callable
     */
    public function getGuard()
    {
        // Add the namespace prefix for the guard classes to the classname
        $classname = '\\Equidea\\Guard\\'.$this->guard[0];
        return $this->createCallable($classname, $this->guard[1], $this->request);
    }
    
    /**
     * @return  string|null
     */
    public function getRedirect() {
        return $this->redirect;
    }
    
    /**
     * @param   array   $guard
     * @param   string  $redirect
     *
     * @return  void
     */
    public function setGuard(array $guard, $redirect)
    {
        $this->guard = $guard;
        $this->redirect = $redirect;
    }
}