<?php

namespace Equidea\Router;

use Equidea\Http\Uri;
use Equidea\Http\Interfaces\RequestInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea
 */
class Parser {

    /**
     * @var \Equidea\Http\Interfaces\RequestInterface
     */
    private $request;

    /**
     * @param   \Equidea\Http\Interfaces\RequestInterface   $request
     */
    public function __construct(RequestInterface $request) {
        $this->request = $request;
    }

    /**
     * @param   mixed   $segment
     *
     * @return  bool
     */
    private function isParam($segment) : bool
    {
        $pos = strpos($segment, '{');
        return $pos !== false && $pos == 0;
    }

    /**
     * @param   string  $param
     *
     * @return  string
     */
    private function getParamName(string $param) : string
    {
        $param = ltrim($param, '{');
        $param = rtrim($param, '}');
        return explode(':', $param)[0];
    }

    /**
     * @param   array   $uriSegments
     * @param   array   $patternSegments
     *
     * @return  \Equidea\Http\Interfaces\RequestInterface
     */
    private function translate(
        array $uriSegments,
        array $patternSegments
    ) : RequestInterface
    {
        // The original Request Input
        $input = $this->request->getInput();
        // Determine the number of segments
        $segments = count($patternSegments);

        // Loop through the pattern segments and find the params
        for ($i = 0; $i < $segments; $i++)
        {
            // Determines whether a segment is a param
            if ($this->isParam($patternSegments[$i]))
            {
                $paramName = $this->getParamName($patternSegments[$i]);
                $input = $input->withAddedGet($paramName, $uriSegments[$i]);
            }
        }
        // Return a clone of Request with the now added GET parameters
        return $this->request->withInput($input);
    }

    /**
     * @param   \Equidea\Router\Route   $route
     *
     * @return  \Equidea\Http\Interfaces\RequestInterface
     */
    public function parse(Route $route) : RequestInterface
    {
        // Get the pattern
        $pattern = $route->getPattern();

        // If no parameter is present, respond with the original request
        if (strpos($pattern, '/{') === false) {
            return $this->request;
        }

        // Get the URI segments
        $originalUri = $this->request->getUri();
        $uriSegments = $originalUri->getSegments();

        // Get the pattern segments
        $patternUri = new Uri($pattern);
        $patternSegments = $patternUri->getSegments();

        // Save the URI params into the Request object and return it
        return $this->translate($uriSegments, $patternSegments);
    }
}
