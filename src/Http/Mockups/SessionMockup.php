<?php

namespace Equidea\Http\Mockups;

use Equidea\Http\Interfaces\SessionInterface;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Http\Mockups
 */
class SessionMockup implements SessionInterface {

    /**
     * @var array
     */
    protected $session = [];

    /**
     * @param   array   $session
     */
    public function __construct(array $session) {
        $this->session = $session;
    }

    /**
     * @param   string  $name
     * @param   mixed   $default
     *
     * @return  mixed
     */
    public function get(string $name = null, $default = null)
    {
        // Checks, whether a specific value was requested
        if (isset($name))
        {
            // Does the requested value exist?
            if (isset($this->session[$name]))
            {
                // Positive: return the value
                return $this->session[$name];
            }
            // Negative: the default value
            return $default;
        }
        // return the entire session
        return $this->session;
    }

    /**
     * @param   string  $name
     * @param   mixed   $value
     *
     * @return  void
     */
    public function set(string $name, $value) {
        $this->session[$name] = $value;
    }

    /**
     * @param   string  $name
     *
     * @return  void
     */
    public function remove(string $name) {
        unset($this->session[$name]);
    }
}
