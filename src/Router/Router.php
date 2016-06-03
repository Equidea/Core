<?php

namespace Equidea\Router;

use Equidea\Http\Interfaces\RequestInterface;
use Equidea\Router\Traits\CallableTrait;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Router
 */
class Router {
    
    use CallableTrait;
    
    /**
     * @var \Equidea\Http\Interfaces\RequestInterface
     */
    private $request;
    
    /**
     * @var array
     */
    private $routes = [];
    
    /**
     * @var array
     */
    private $notFound = [];
    
    /**
     * @var \Equidea\Router\Matcher
     */
    private $matcher;
    
    /**
     * @var \Equidea\Router\Parser
     */
    private $parser;
    
    /**
     * @var boolean
     */
    private $match = false;
    
    /**
     * @param   \Equidea\Http\Interfaces\RequestInterface
     */
    public function __construct(RequestInterface $request)
    {
        $this->parser = new Parser($request);
        $this->matcher = new Matcher($request);
        $this->request = $request;
    }
    
    /**
     * @param   \Equidea\Router\Route
     *
     * @return  void
     */
    public function addRoute(Route $route) {
        $this->routes[] = $route;
    }
    
    /**
     * @param   array   $controller
     *
     * @return  void
     */
    public function addNotFound(array $controller) {
        $this->notFound = $controller;
    }
    
    /**
     * @param   callable    $guard
     * @param   string      $redirect
     *
     * @return  void
     */
    private function protect($guard, $redirect)
    {
        // Check if the guard went off
        $valid = call_user_func($guard);
        
        // if it did, redirect to the specified location
        if ($valid === false) {
            header('Location: '. $redirect);
            exit;
        }
    }
    
    /**
     * @param   \Equidea\Router\Route   $route
     *
     * @return  boolean
     */
    private function guard(Route $route)
    {
        if ($route->hasGuard()) {
            $this->protect($route->getGuard(), $route->getRedirect());
        }
        return true;
    }
    
    /**
     * @param   \Equidea\Router\Route   $route
     *
     * @return  void
     */
    private function match(Route $route)
    { 
        // The pattern given by the user
        $pattern = $route->getPattern();
        
        // Run the callable
        if ($this->matcher->match($route) && $this->guard($route)) {
            $params = $this->parser->parse($pattern);
            $this->match = true;
            call_user_func_array($route->getController(), $params);
        }
    }
    
    /**
     * @return  void
     */
    private function callNotFound()
    {
        $classname = '\\Equidea\\Controller\\'.$this->notFound[0];
        $notFound = $this->createCallable($classname, $this->notFound[1], $this->request);
        call_user_func($notFound);
    }
    
    /**
     * @return  void
     */
    public function dispatch()
    {
        // Searches the routes array for any matches
        foreach ($this->routes as $route) {
            $this->match($route);
        }
        
        if ($this->match === false) {
            $this->callNotFound();
        }
    }
}