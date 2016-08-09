<?php

namespace Equidea;

use Equidea\Http\Interfaces\RequestInterface;
use Equidea\Http\Response;

use Equidea\Router\Route;
use Equidea\Router\Router;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea
 */
class Equidea {

    /**
     * @var \Equidea\Http\Interfaces\RequestInterface
     */
    private static $request;
    
    /**
     * @var \Equidea\Router\Router
     */
    private static $router;
    
    /**
     * @var string
     */
    private static $group = '';
    
    /**
     * @var array|null
     */
    private static $guard = null;
    
    /**
     * @var null|string
     */
    private static $redirect = null;
    
    /**
     * @var array
     */
    private static $config = [];
    
    /**
     * @param   \Equidea\Http\Interfaces\RequestInterface
     *
     * @return  void
     */
    public static function register(RequestInterface $request)
    {
        self::$request = $request;
        self::$router = new Router($request);
    }
    
    /**
     * @param   string  $name
     *
     * @return  mixed
     */
    public static function config($name) {
        return self::$config[$name];
    }
    
    /**
     * @param   string  $name
     * @param   mixed   $value
     *
     * @return  void
     */
    public static function setConfig($name, $value) {
        self::$config[$name] = $value;
    }
    
    /**
     * @param   string  $pattern
     * @param   array   $controller
     *
     * @return  void
     */
    public static function get($pattern, array $controller) {
        self::addRoute($pattern, $controller, ['GET']);
    }
    
    /**
     * @param   string  $pattern
     * @param   array   $controller
     *
     * @return  void
     */
    public static function post($pattern, array $controller) {
        self::addRoute($pattern, $controller, ['POST']);
    }
    
    /**
     * @param   string  $pattern
     * @param   array   $controller
     *
     * @return  void
     */
    public static function any($pattern, array $controller) {
        self::addRoute($pattern, $controller, ['GET', 'POST']);
    }
    
    /**
     * @param   string      $pattern
     * @param   callable    $routes
     *
     * @return  void
     */
    public static function group($pattern, callable $routes)
    {
        // Add the group prefix to the settings
        self::$group = $pattern;
        
        // Add the routes to the router
        call_user_func($routes);
        
        // Reset the settings and remove the group prefix
        self::$group = '';
    }
    
    /**
     * @param   array       $guard
     * @param   callable    $routes
     * @param   string      $redirect
     *
     * @return  void
     */
    public static function guard(array $guard, callable $routes, $redirect)
    {
        // Add a guard to the settings
        self::$guard = $guard;
        self::$redirect = $redirect;
        
        // Add the routes to the router
        call_user_func($routes);
        
        // Reset the settings and remove the guards
        self::$guard = null;
        self::$redirect = null;
    }
    
    /**
     * @param   string  $pattern
     * @param   array   $controller
     * @param   array   $methods
     *
     * @return  void
     */
    private static function addRoute($pattern, array $controller, array $methods)
    {
        // Create new route entity
        $route = new Route(self::$request, self::$group.$pattern, $controller, $methods);
        
        // If a guard is present, add it to the route object
        if (!is_null(self::$guard) && !is_null(self::$redirect)) {
            $route->setGuard(self::$guard, self::$redirect);
        }
        
        // Add route entity to the internal route collection
        self::$router->addRoute($route);
    }
    
    /**
     * @param   array   $controller
     *
     * @return  void
     */
    public static function notFound(array $controller) {
        self::$router->addNotFound($controller);
    }
    
    /**
     * @return  void
     */
    public static function respond()
    {
        // Get the string returned by the controller
        $content = self::$router->dispatch();
        
        // Send the response
        $response = new Response($content);
        $response->send();
    }
}