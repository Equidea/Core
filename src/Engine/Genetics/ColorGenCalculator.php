<?php

namespace Equidea\Engine\Genetics;

use Equidea\Engine\Entity\ColorGenEntity;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Engine\Genetics
 */
 class ColorGenCalculator extends AbstractGenCalculator {

    public function __construct() {
        parent::__construct(ColorGenEntity::$alleleNames);
    }

    /**
     * @param   \Equidea\Engine\Entity\ColorGenEntity   $father
     * @param   \Equidea\Engine\Entity\ColorGenEntity   $mother
     *
     * @return  \Equidea\Engine\Entity\ColorGenEntity
     */
    public function calculateFoal(
        ColorGenEntity $father,
        ColorGenEntity $mother
    ) : ColorGenEntity
    {
        $fGenes = $father->getAllAlleles();
        $mGenes = $mother->getAllAlleles();
        $cGenes = $this->calculateAllAlleles($fGenes, $mGenes);

        return new ColorGenEntity($cGenes);
    }
}
