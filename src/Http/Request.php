<?php

namespace Equidea\Http;

use Equidea\Http\Interfaces\{InputInterface, RequestInterface};
use Equidea\Http\Interfaces\{SessionInterface, UriInterface};

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Http
 */
class Request implements RequestInterface {
    
    /**
     * @var string
     */
    protected $method;
    
    /**
     * @var \Equidea\Http\Interfaces\UriInterface
     */
    protected $uri;
    
    /**
     * @var \Equidea\Http\Interfaces\InputInterface
     */
    protected $input;
    
    /**
     * @var \Equidea\Http\Interfaces\SessionInterface
     */
    protected $session;
    
    /**
     * @param   string                                      $method
     * @param   \Equidea\Http\Interfaces\UriInterface       $uri
     * @param   \Equidea\Http\Interfaces\InputInterface     $input
     * @param   \Equidea\Http\Interfaces\SessionInterface   $session
     */
    public function __construct(
        string $method,
        UriInterface $uri,
        InputInterface $input,
        SessionInterface $session
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->input = $input;
        $this->session = $session;
    }
    
    /**
     * @return  self
     */
    public static function createFromGlobals()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = new Uri($_SERVER['REQUEST_URI']);
        $input = new Input($_GET, $_POST);
        $session = new Session();
        return new static($method, $uri, $input, $session);
    }
    
    /**
     * @return  string
     */
    public function getMethod():string {
        return $this->method;
    }
    
    /**
     * @return  \Equidea\Http\Interfaces\UriInterface
     */
    public function getUri() {
        return $this->uri;
    }
    
    /**
     * @return  \Equidea\Http\Interfaces\InputInterface
     */
    public function getInput() {
        return $this->input;
    }
    
    /**
     * @return  \Equidea\Http\Interfaces\SessionInterface
     */
    public function getSession() {
        return $this->session;
    }
    
    /**
     * @param   string  $method
     *
     * @return  self
     */
    public function withMethod(string $method)
    {
        $clone = clone $this;
        $clone->method = $method;
        return $clone;
    }
    
    /**
     * @param   \Equidea\Http\Interfaces\UriInterface   $uri
     *
     * @return  self
     */
    public function withUri(UriInterface $uri)
    {
        $clone = clone $this;
        $clone->uri = $uri;
        return $clone;
    }
    
    /**
     * @param   \Equidea\Http\Interfaces\InputInterface $input
     *
     * @return  self
     */
    public function withInput(InputInterface $input)
    {
        $clone = clone $this;
        $clone->input = $input;
        return $clone;
    }
    
    /**
     * @param   \Equidea\Http\Interfaces\SessionInterface   $session
     *
     * @return  self
     */
    public function withSession(SessionInterface $session)
    {
        $clone = clone $this;
        $clone->session = $session;
        return $clone;
    }
    
    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function get(string $name = null, $default = null) {
        return $this->input->get($name, $default);
    }
    
    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function post(string $name = null, $default = null) {
        return $this->input->post($name, $default);
    }
    
    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function session(string $name = null, $default = null) {
        return $this->session->get($name, $default);
    }
}