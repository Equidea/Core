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
    private $viewPath = '../app/views/';

    /**
     * @var string
     */
    private $langPath = '../app/lang/';

    /**
     * @var string
     */
    private $extension = '.php';

    /**
     * @var string
     */
    private $lang = 'EN';

    /**
     * @param   array   $config
     */
    public function __construct(array $config)
    {
        $this->viewPath = $config['viewPath'];
        $this->langPath = $config['langPath'];
        $this->extension = $config['extension'];
        $this->lang = $config['lang'];
    }

    /**
     * @param   string  $name
     * @param   array   $data
     *
     * @return  string
     */
    public function render(string $name, array $data = []) : string
    {
        $template = new Template($this->viewPath, $name, $this->extension, $data);
        return $template->render();
    }

    /**
     * @param   string  $name
     *
     * @return  \Equidea\View\Translation
     */
    public function translation($name) {
        return new Translation($this->langPath, $this->lang, $name, $this->extension);
    }
}
