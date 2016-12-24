<?php

namespace Equidea\Router;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Router
 */
class Route {

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var array
     */
    private $controller = [];

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
     * @param   string  $pattern
     * @param   array   $controller
     * @param   array   $methods
     */
    public function __construct(
        string $pattern,
        array $controller,
        array $methods
    ) {
        $this->setPattern($pattern);
        $this->setController($controller);
        $this->setMethods($methods);
    }

    /**
     * @return  string
     */
    public function getPattern() : string {
        return $this->pattern;
    }

    /**
     * @param   string  $pattern
     *
     * @return  void
     */
    public function setPattern(string $pattern) {
        $this->pattern = '/'.trim($pattern, '/');
    }

    /**
     * @return  array
     */
    public function getMethods() : array {
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
     * @return  array
     */
    public function getController() : array {
        return $this->controller;
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
    public function hasGuard() : bool {
        return !is_null($this->guard);
    }

    /**
     * @return  array
     */
    public function getGuard() : array {
        return $this->guard;
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
    public function setGuard(array $guard, string $redirect)
    {
        $this->guard = $guard;
        $this->redirect = $redirect;
    }
}
