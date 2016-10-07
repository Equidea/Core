<?php

namespace Equidea;

use Equidea\Http\Interfaces\RequestInterface;
use Equidea\Http\Response;

use Equidea\Router\{Route,Router};

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
    public static function config(string $name) {
        return self::$config[$name];
    }
    
    /**
     * @param   string  $name
     * @param   mixed   $value
     *
     * @return  void
     */
    public static function setConfig(string $name, $value) {
        self::$config[$name] = $value;
    }
    
    /**
     * A shortcut function to Equidea::addRoute() for the HTTP GET method
     *
     * @param   string  $pattern
     * @param   array   $controller
     *
     * @return  void
     */
    public static function get(string $pattern, array $controller) {
        self::addRoute($pattern, $controller, ['GET']);
    }
    
    /**
     * A shortcut function to Equidea::addRoute() for the HTTP POST method
     *
     * @param   string  $pattern
     * @param   array   $controller
     *
     * @return  void
     */
    public static function post(string $pattern, array $controller) {
        self::addRoute($pattern, $controller, ['POST']);
    }
    
    /**
     * A shortcut function to Equidea::addRoute() for the HTTP GET/POST methods
     *
     * @param   string  $pattern
     * @param   array   $controller
     *
     * @return  void
     */
    public static function any(string $pattern, array $controller) {
        self::addRoute($pattern, $controller, ['GET', 'POST']);
    }
    
    /**
     * Adds a group of Routes as a callback function to the internal router.
     * The group collects all of the Routes with a similar pattern and
     * provides a shortcut by adding the same pattern that all of them share 
     * to the start
     *
     * @param   string      $pattern
     * @param   callable    $routes
     *
     * @return  void
     */
    public static function group(string $pattern, callable $routes)
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
    public static function guard(array $guard, callable $routes, string $redirect)
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
    public static function addRoute(string $pattern, array $controller, array $methods)
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
     * Runs the router and either sends a HTTP Response from a matched Route
     * or sends the notFound fallback Route.
     *
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