<?php

namespace Equidea\View;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Database
 */
class View {
    
    /**
     * @var string
     */
    public $path = '../app/views/';
    
    /**
     * @var string
     */
    public $extension = '.php';
    
    /**
     * @param   string  $path
     * @param   string  $extension
     *
     * @return  void
     */
    public function configure($path, $extension)
    {
        $this->path = $path;
        $this->extension = $extension;
    }
    
    /**
     * @param   string  $name
     * @param   array   $data
     *
     * @return  string
     */
    public function render($name, $data = [])
    {
        $template = new Template($this->path, $name, $this->extension, $data);
        return $template->render();
    }
}