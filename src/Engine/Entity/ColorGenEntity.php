<?php

namespace Equidea\Engine\Entity;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Engine\Entity
 */
class ColorGenEntity {

    /**
     * @var array
     */
    public static $alleles = [
        0 => 'agouti',
        1 => 'extension',
        2 => 'grey'
    ];

    /**
     * @var int
     */
    private $agouti;

    /**
     * @var int
     */
    private $extension;

    /**
     * @var int
     */
    private $grey;

    /**
     * @return  int
     */
    public function getAgouti() : int {
        return $this->agouti;
    }

    /**
     * @return  int
     */
    public function getExtension() : int {
        return $this->extension;
    }

    /**
     * @return  int
     */
    public function getGrey() : int {
        return $this->grey;
    }

    /**
     * @return  array
     */
    public function getAllAlleles() : array
    {
        return [
            'agouti' => $this->getAgouti(),
            'extension' => $this->getExtension(),
            'grey' => $this->getGrey()
        ];
    }

    /**
     * @param   array   $alleles
     *
     * @return  void
     */
    public function setAllAlleles(array $alleles)
    {
        $this->agouti = $alleles['agouti'];
        $this->extension = $alleles['extension'];
        $this->grey = $alleles['grey'];
    }
}
