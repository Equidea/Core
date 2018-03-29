<?php

namespace Equidea\Core\Router;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Core\Router
 */
class Route {

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
    private $methods;

    /**
     * @var boolean
     */
    private $ajax;

    /**
     * @param   string  $pattern
     * @param   array   $controller
     * @param   array   $methods
     * @param   boolean $ajax
     */
    public function __construct(
        string $pattern,
        array $controller,
        array $methods,
        bool $ajax
    ) {
        $this->setPattern($pattern);
        $this->controller = $controller;
        $this->methods = $methods;
        $this->ajax = $ajax;
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
     * @return  string
     */
    public function getPattern() : string {
        return $this->pattern;
    }

    /**
     * @return  array
     */
    public function getController() : array {
        return $this->controller;
    }

    /**
     * @return  array
     */
    public function getMethods() : array {
        return $this->methods;
    }

    /**
     * @return  boolean
     */
    public function isAjax() : bool {
        return $this->ajax;
    }
}
