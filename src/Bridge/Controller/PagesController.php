<?php

namespace Equidea\Bridge\Controller;

use Equidea\Core\Http\Interfaces\{RequestInterface,ResponseInterface};
use Equidea\Core\Utility\Container;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Bridge\Controller
 */
class PagesController {

    /**
     * @var \Equidea\Core\Http\Interfaces\RequestInterface
     */
    protected $request;

    /**
     * @var \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    protected $response;

    /**
     * @var \Equidea\Core\Utility\Container
     */
    protected $container;

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
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function index() : ResponseInterface {
        return $this->response->withBody('Hello World');
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function json() : ResponseInterface
    {
        $json = json_encode(['var' => 'Some Value']);
        return $this->response->withType('json')->withBody($json);
    }

    /**
     * @return  \Equidea\Core\Http\Interfaces\ResponseInterface
     */
    public function notFound() : ResponseInterface {
        return $this->response->withCode(404)->withBody('404: Not Found');
    }
}
