<?php

namespace Equidea\Core\Router;

use Equidea\Core\Http\Interfaces\{RequestInterface,ResponseInterface};
use Equidea\Core\Utility\Container;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Core\Router
 */
class Router {

    /**
     * @var \Equidea\Core\Http\Interfaces\RequestInterface
     */
    private $request;

    /**
     * @var \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    private $response;

    /**
     * @var \Equidea\Core\Utility\Container
     */
    private $container;

    /**
     * @var \Equidea\Core\Router\Route[]
     */
    private $routes = [];

    /**
     * @var array
     */
    private $notFound;

    /**
     * @param   \Equidea\Core\Http\Interfaces\RequestInterface  $request
     * @param   \Equidea\Core\Http\Interfaces\ResponseInterface $response
     * @param   \Equidea\Core\Utility\Container                 $container
     */
    public function __construct(
        RequestInterface $request,
        ResponseInterface $response,
        Container $container
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    /**
     * @param   \Equidea\Core\Router\Route  $route
     *
     * @return  void
     */
    public function addRoute(Route $route) {
        $this->routes[] = $route;
    }

    /**
     * @param   array   $notFound
     *
     * @return void
     */
    public function addNotFound(array $notFound) {
        $this->notFound = $notFound;
    }

    /**
     * @return  array
     */
    private function find() : array
    {
        // Create new Matcher
        $matcher = new Matcher($this->request);

        // Searches the routes array for any matches
        foreach ($this->routes as $route) {
            // And if there is a match return the controller
            if ($matcher->match($route)) {
                $parser = new Parser($this->request);
                $this->request = $parser->parse($route);
                return $route->getController();
            }
        }

        // If there was no match notFound will be returned
        return $this->notFound;
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function respond() : ResponseInterface
    {
        // Gets the controller
        $controller = $this->find();
        $args = [$this->request, $this->response, $this->container];
        $class = $this->container->retrieve($controller[0], $args);

        // Call the method
        $method = $controller[1];
        return call_user_func([$class, $method]);
    }
}
