<?php

namespace Equidea\Core\Templating;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Core\Templating
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
    private $data;

    /**
     * @var string
     */
    private $charset;

    /**
     * @var \Equidea\Core\Templating\Translation
     */
    private $translation;

    /**
     * @param   string  $name
     * @param   array   $data
     * @param   array   $config
     */
    public function __construct(string $name, array $data, array $config)
    {
        // The file path info
        $this->path = $config['view_path'];
        $this->name = $name;
        $this->extension = $config['view_extension'];

        // The template params
        $this->data = $data;

        // Character set used in Template::escape()
        $this->charset = $config['view_charset'];

        // Create the Translation
        $language = $config['view_language'];
        $this->createTranslation($language, $config['lang_path']);
    }

    /**
     * @return  string
     */
    public function render() : string
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
    private function getTemplate($name = null) : string
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
    protected function escape(string $string) {
        echo htmlspecialchars($string, ENT_QUOTES, $this->charset);
    }

    /**
     * @param   string  $name
     * @param   array   $data
     *
     * @return  void
     */
    protected function insert(string $name, $data = [])
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

    /**
     * @param   string  $language
     * @param   string  $path
     *
     * @return  void
     */
    private function createTranslation(string $language, string $path)
    {
        $this->translation = new Translation(
            $path, $this->extension, $language
        );
    }

    /**
     * @param   array   $names
     *
     * @return  void
     */
    protected function loadTranslations(array $names)
    {
        foreach ($names as $name) {
            $this->translation->loadTranslations($name);
        }
    }

    /**
     * @param   string  $name
     *
     * @return  void
     */
    protected function translate(string $name) {
        echo $this->translation->translate($name);
    }
}
