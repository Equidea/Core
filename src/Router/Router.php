<?php

namespace Equidea\Router;

use Equidea\Http\Interfaces\{RequestInterface,ResponseInterface};
use Equidea\Utility\Container;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea
 */
class Router {

    /**
     * @var \Equidea\Http\Interfaces\RequestInterface
     */
    private $request;

    /**
     * @var \Equidea\Http\Interfaces\ResponseInterface
     */
    private $response;

    /**
     * @var \Equidea\Utility\Container
     */
    private $container;

    /**
     * @var \Equidea\Router\Route[]
     */
    private $routes = [];

    /**
     * @var callable
     */
    private $notFound;

    /**
     * @param   \Equidea\Http\Interfaces\RequestInterface   $request
     * @param   \Equidea\Http\Interfaces\ResponseInterface  $response
     * @param   \Equidea\Utility\Container                  $container
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
     * @param   \Equidea\Router\Route   $route
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
     * @return  \Equidea\Http\Interfaces\ResponseInterface
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
