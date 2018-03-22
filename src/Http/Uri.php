<?php

namespace Equidea\Http;

use Equidea\Http\Interfaces\UriInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Http
 */
class Uri implements UriInterface {

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $segments = [];

    /**
     * @param   string  $uri
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
        $this->findSegments();
    }

    /**
     * @return  string
     */
    public function getUri() : string {
        return $this->uri;
    }

    /**
     * @return  void
     */
    public function findSegments()
    {
        // Normalize the uri and pattern
        $uri = trim($this->uri, '/');

        // Split it into its segments
        $segments = explode('/', $uri);

        $this->segments = $segments;
    }

    /**
     * @return  array
     */
    public function getSegments() : array {
        return $this->segments;
    }

    /**
     * @param   int     $key
     *
     * @return  string
     */
    public function getSegment(int $key) : string {
        return $this->segments[$key];
    }
}
