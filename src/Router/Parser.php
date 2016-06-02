<?php

namespace Equidea\Router;

use Equidea\Http\Uri;
use Equidea\Http\Request;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Router
 */
class Parser {

    /**
     * @var \Equidea\Http\Request
     */
    private $request;
    
    /**
     * @param   \Equidea\Http\Request   $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    /**
     * @param   mixed   $segment
     *
     * @return  bool
     */
    private function isParam($segment) {
        return strpos($segment, '{') !== false;
    }
    
    /**
     * @param   array   $uriSegments
     * @param   array   $patternSegments
     *
     * @return  array
     */
    private function getParams(array $uriSegments, array $patternSegments)
    {
        $params = [];
        
        // Determine the number of segments
        $segments = count($patternSegments);
        
        // Loop through the pattern segments and find the params
        for ($i = 0; $i < $segments; $i++)
        {   
            // Determines whether a segment is a param
            if ($this->isParam($patternSegments[$i])) {
                $params[] = $uriSegments[$i];
            }
        }
        return $params;
    }
    
    /**
     * @param   string  $pattern
     *
     * @return  array
     */
    public function parse($pattern)
    {
        // The Segments of the HTTP URI
        $uriObject = $this->request->getUri();
        $uriSegments = $uriObject->getSegments();
        
        // The segments of the route pattern
        $pattern = new Uri($pattern);
        $patternSegments = $pattern->getSegments();
        
        // Find the route parameters and return them
        return $this->getParams($uriSegments, $patternSegments);
    }
}