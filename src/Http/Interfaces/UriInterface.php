<?php

namespace Equidea\Http\Interfaces;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Http\Interfaces
 */
interface UriInterface {

    /**
     * @return  string
     */
    public function getUri() : string;

    /**
     * @return  void
     */
    public function findSegments();

    /**
     * @return  array
     */
    public function getSegments() : array;

    /**
     * @param   int     $key
     *
     * @return  string
     */
    public function getSegment(int $key) : string;
}
