<?php

namespace Equidea\Http\Interfaces;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Http\Interfaces
 */
interface RequestInterface {

    /**
     * @return  string
     */
    public function getMethod() : string;

    /**
     * @return  \Equidea\Http\Interfaces\UriInterface
     */
    public function getUri();

    /**
     * @return  \Equidea\Http\Interfaces\InputInterface
     */
    public function getInput();

    /**
     * @return  \Equidea\Http\Interfaces\SessionInterface
     */
    public function getSession();

    /**
     * @param   string  $method
     *
     * @return  self
     */
    public function withMethod(string $method);

    /**
     * @param   \Equidea\Http\Interfaces\UriInterface   $uri
     *
     * @return  self
     */
    public function withUri(UriInterface $uri);

    /**
     * @param   \Equidea\Http\Interfaces\InputInterface $input
     *
     * @return  self
     */
    public function withInput(InputInterface $input);

    /**
     * @param   \Equidea\Http\Interfaces\SessionInterface   $session
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
