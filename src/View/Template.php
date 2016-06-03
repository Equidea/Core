<?php

namespace Equidea\View;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Database
 */
class Template {
    
    /**
     * @var string
     */
    private $path;
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var string
     */
    private $extension;
    
    /**
     * @var array
     */
    private $data = [];
    
    /**
     * @param   string  $name
     * @param   array   $data
     */
    public function __construct($path, $name, $extension, $data = [])
    {
        $this->path = $path;
        $this->name = $name;
        $this->extension = $extension;
        $this->data = $data;
    }
    
    /**
     * @return  string
     */
    public function render()
    {
        // Extracting the variables
        extract($this->data);
        
        // Start output buffering
        ob_start();
        
        // Include the template file
        if (file_exists($this->getTemplate())) {
            include $this->getTemplate();;
        }
        
        // End output buffering and return rendered template
        return ob_get_clean();
    }
    
    /**
     * @return  void
     */
    private function getTemplate() {
        return $this->path.$this->name.$this->extension;
    }
    
    /**
     * @param   string  $string
     *
     * @return  void
     */
    public function escape($string) {
        echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}