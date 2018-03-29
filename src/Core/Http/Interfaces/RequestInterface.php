<?php

namespace Equidea\Core\Http\Interfaces;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Core\Http\Interfaces
 */
interface RequestInterface {

    /**
     * @return  string
     */
    public function getMethod() : string;

    /**
     * @return  \Equidea\Core\Http\Interfaces\UriInterface
     */
    public function getUri();

    /**
     * @return  \Equidea\Core\Http\Interfaces\InputInterface
     */
    public function getInput();

    /**
     * @return  \Equidea\Core\Http\Interfaces\SessionInterface
     */
    public function getSession();

    /**
     * @param   string  $method
     *
     * @return  self
     */
    public function withMethod(string $method);

    /**
     * @param   \Equidea\Core\Http\Interfaces\UriInterface  $uri
     *
     * @return  self
     */
    public function withUri(UriInterface $uri);

    /**
     * @param   \Equidea\Core\Http\Interfaces\InputInterface    $input
     *
     * @return  self
     */
    public function withInput(InputInterface $input);

    /**
     * @param   \Equidea\Core\Http\Interfaces\SessionInterface  $session
     */
    public function withSession(SessionInterface $session);

    /**
     * @return  string
     */
    public function uri() : string;

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function get(string $name = null, $default = null);

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function post(string $name = null, $default = null);

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function session(string $name = null, $default = null);
}
