<?php

namespace Equidea\Router;

use Equidea\Container\ServiceContainer;
use Equidea\Http\Interfaces\RequestInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Router
 */
class Router {

    /**
     * @var \Equidea\Http\Interfaces\RequestInterface
     */
    private $request;

    /**
     * @var \Equidea\Container\ServiceContainer
     */
    private $container;

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
     * @var null|string
     */
    private $matchedRoute = null;

    /**
     * @param   \Equidea\Http\Interfaces\RequestInterface   $request
     * @param   \Equidea\Container\ServiceContainer         $container
     */
    public function __construct(
        RequestInterface $request,
        ServiceContainer $container
    ) {
        $this->parser = new Parser($request);
        $this->matcher = new Matcher($request);
        $this->request = $request;
        $this->container = $container;
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
    private function protect(callable $guard, string $redirect)
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
    private function guard(Route $route) : bool
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
            $this->matchedRoute = call_user_func_array($route->getController(), $params);
        }
    }

    /**
     * @return  string
     */
    private function callNotFound() : string
    {
        $classname = $this->notFound[0];
        $method = $this->notFound[1];

        $notFound = $this->createCallable($classname, $method);
        return call_user_func($notFound);
    }

    /**
     * @param   string  $classname
     * @param   string  $method
     *
     * @return  callable
     */
    public function createCallable(string $classname, string $method) : callable
    {
        // Create new anonymous function which calls controller -> method
        $class = $this->container->retrieve($classname, [$this->request]);
        $callable = function() use ($class, $method) {
            return call_user_func_array([$class, $method], func_get_args());
        };
        return $callable;
    }

    /**
     * @return  string
     */
    public function dispatch() : string
    {
        // Searches the routes array for any matches
        foreach ($this->routes as $route) {
            $this->match($route);
        }

        if ($this->match === false) {
            return $this->callNotFound();
        }

        return $this->matchedRoute;
    }
}
