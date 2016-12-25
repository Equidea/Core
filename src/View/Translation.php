<?php

namespace Equidea\View;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\View
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
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $translations = [];

    /**
     * @param   string  $path
     * @param   string  $lang
     * @param   string  $name
     * @param   string  $extension
     */
    public function __construct(
        string $path,
        string $lang,
        string $name,
        string $extension
    ) {
        $this->path = $path;
        $this->name = $name;
        $this->language = $lang;
        $this->extension = $extension;
        $this->loadTranslations();
    }

    /**
     * @return  void
     */
    private function loadTranslations()
    {
        // Build the path to the translation file
        $path = $this->path.$this->language.'/'.$this->name.$this->extension;

        // If the file exists, load its content.
        if (file_exists($path)) {
            $this->translations = include $path;
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
