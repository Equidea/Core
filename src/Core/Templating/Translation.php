<?php

namespace Equidea\Core\Templating;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Core\Templating
 */
class Translation {

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var string
     */
    private $language;

    /**
     * @var array
     */
    private $translations = [];

    /**
     * @param   string  $path
     * @param   string  $extension
     * @param   string  $language
     */
    public function __construct(
        string $path,
        string $extension,
        string $language
    ) {
        $this->path = $path;
        $this->extension = $extension;
        $this->language = $language;
    }

    /**
     * @param   string  $name
     *
     * @return  void
     */
    public function loadTranslations($name)
    {
        // Build the path to the translation file
        $path = $this->path.$this->language.'/'.$name.$this->extension;
        // If the file exists, load its content.
        if (file_exists($path)) {
            $loaded = include $path;
            $this->translations = array_merge($loaded, $this->translations);
        }
    }

    /**
     * @param   string  $name
     *
     * @return  string
     */
    public function translate(string $name) : string
    {
        // If a translation is available, return its value.
        if (isset($this->translations[$name])) {
            return $this->translations[$name];
        }
        // Otherwise return the translation name.
        return $name;
    }
}
