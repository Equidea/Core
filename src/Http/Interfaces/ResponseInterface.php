<?php

namespace Equidea\Http\Interfaces;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Http\Interfaces
 */
interface ResponseInterface {
    
    /**
     * @return  mixed
     */
    public function getContent();
    
    /**
     * @return  int
     */
    public function getStatus();
    
    /**
     * @return  string
     */
    public function getMessage();
    
    /**
     * @param   string  $content
     *
     * @return  self
     */
    public function withContent($content);
    
    /**
     * @param   int $status
     *
     * @return  self
     */
    public function withStatus($status);
    
    /**
     * @return  void
     */
    public function send();
}