<?php

namespace Equidea;

use Equidea\Utilities\Container;
use Equidea\Http\Interfaces\{RequestInterface,ResponseInterface};
use Equidea\Router\{Route,Router};

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea
 */
class Equidea {

    /**
     * @var \Equidea\Router\Router
     */
    private static $router;

    /**
     * @var string
     */
    private static $group = '';

    /**
     * @param   \Equidea\Http\Interfaces\RequestInterface   $request
     * @param   \Equidea\Http\Interfaces\ResponseInterface  $response
     * @param   \Equidea\Utility\Container                  $container
     *
     * @return  void
     */
    public static function register(
        RequestInterface $request,
        ResponseInterface $response,
        Container $container
    ) {
        self::$router = new Router($request, $response, $container);
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
     * A shortcut function to Equidea::addRoute() for the AJAX requests for both
     * GET and POST requests.
     *
     * @param   string  $pattern
     * @param   array   $controller
     * @param   array   $methods
     *
     * @return  void
     */
    public static function ajax(
        string $pattern,
        array $controller,
        array $methods
    ) {
        self::addRoute($pattern, $controller, $methods, true);
    }

    /**
     * Adds a group of Routes as a callback function to the internal router.
     * The group collects all of the Routes with a similar pattern and
     * provides a shortcut by adding the same pattern that all of them share
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
     * @param   string  $pattern
     * @param   array   $controller
     * @param   array   $methods
     * @param   boolean $ajax
     *
     * @return  void
     */
    public static function addRoute(
        string $pattern,
        array $controller,
        array $methods,
        bool $ajax = false
    ) {
        // Create new route entity
        $route = new Route(self::$group.$pattern, $controller, $methods, $ajax);

        // Add the route entity to the internal route collection
        self::$router->addRoute($route);
    }

    /**
     * Add the action (Controller name and method name) the router will run,
     * if no matching Route for a Request can be found.
     *
     * @param   array   $controller
     *
     * @return  void
     */
    public static function notFound(array $controller) {
        self::$router->addNotFound($controller);
    }

    /**
     * Runs the router and either sends a HTTP Response from a matched Route
     * or the notFound fallback Route.
     *
     * @return  void
     */
    public static function respond()
    {
        // Get the string returned by the controller
        $response = self::$router->respond();

        $protocol = $response->getProtocol();
        $code = $response->getCode();
        $message = $response->getMessage();

        // Translate the Response
        header($protocol . ' ' . $code . ' ' . $message);
        header('Content-Type: ' . $response->getType());
        echo $response->getBody();
    }
}
