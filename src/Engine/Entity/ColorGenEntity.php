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
    public static $alleleNames = [
        0 => 'agouti',
        1 => 'extension',
        2 => 'shading',
        3 => 'grey',
        4 => 'tobiano'
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
    private $shading;

    /**
     * @var int
     */
    private $grey;

    /**
     * @var int
     */
    private $tobiano;

    /**
     * @param   array   $alleles
     */
    public function __construct(array $alleles) {
        $this->setAllAlleles($alleles);
    }

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
    public function getShading() : int {
        return $this->shading;
    }

    /**
     * @return  int
     */
    public function getGrey() : int {
        return $this->grey;
    }

    /**
     * @return  int
     */
    public function getTobiano() : int {
        return $this->tobiano;
    }

    /**
     * @return  array
     */
    public function getAllAlleles() : array
    {
        return [
            'agouti' => $this->getAgouti(),
            'extension' => $this->getExtension(),
            'shading' => $this->getShading(),
            'grey' => $this->getGrey(),
            'tobiano' => $this->getTobiano()
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
        $this->shading = $alleles['shading'];
        $this->grey = $alleles['grey'];
        $this->tobiano = $alleles['tobiano'];
    }
}
