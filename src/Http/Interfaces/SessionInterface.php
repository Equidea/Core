<?php

namespace Equidea\Http\Interfaces;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Http\Interfaces
 */
interface SessionInterface {
    
    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function get($name = null, $default = null);
    
    /**
     * @param   string  $name
     * @param   mixed   $value
     *
     * @return  void
     */
    public function set($name, $value);
    
    /**
     * @param   string  $name
     *
     * @return  void
     */
    public function remove($name);
}