<?php

namespace Equidea\View;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\View
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
     * @param   array   $config
     */
    public function __construct(array $config)
    {
        $this->path = $config['path'];
        $this->extension = $config['extension'];
    }
    
    /**
     * @param   string  $name
     * @param   array   $data
     *
     * @return  string
     */
    public function render(string $name, array $data = []):string
    {
        $template = new Template($this->path, $name, $this->extension, $data);
        return $template->render();
    }
}