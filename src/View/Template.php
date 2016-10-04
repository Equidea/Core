<?php

namespace Equidea\View;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\View
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
     * @param   string  $path
     * @param   string  $name
     * @param   string  $extension
     * @param   array   $data
     */
    public function __construct(
        string $path,
        string $name,
        string $extension,
        array $data = []
    ) {
        $this->path = $path;
        $this->name = $name;
        $this->extension = $extension;
        $this->data = $data;
    }
    
    /**
     * @return  string
     */
    public function render():string
    {
        // Extracting the variables
        extract($this->data);
        
        // Start output buffering
        ob_start();
        
        // Include the template file
        if (file_exists($this->getTemplate())) {
            include $this->getTemplate();
        }
        
        // End output buffering and return rendered template
        return ob_get_clean();
    }
    
    /**
     * @param   string|null $name
     *
     * @return  string
     */
    private function getTemplate($name = null):string
    {
        // If no name was set, load the original template
        if (is_null($name)) {
            $name = $this->name;
        }
        // Return the full path
        return $this->path.$name.$this->extension;
    }
    
    /**
     * @param   string  $string
     *
     * @return  void
     */
    public function escape(string $string) {
        echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * @param   string  $name
     * @param   array   $data
     *
     * @return  void
     */
    public function insert(string $name, $data = [])
    {
        // Extracting the file wide variables
        extract($this->data);
        // Extracting the variables
        extract($data);
        
        // Include the template file
        if (file_exists($this->getTemplate($name))) {
            include $this->getTemplate($name);
        }
    }
}