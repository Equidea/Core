<?php

namespace Equidea\Engine\Genetics;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2016-2018 Lisa Saalfrank
 * @license     MIT License http://opensource.org/licenses/MIT
 * @package     Equidea\Engine\Genetics
 */
abstract class AbstractGenCalculator {

    /**
     * @var array
     */
    protected $alleleNames = [];

    /**
     * @param   array   $alleleNames
     */
    public function __construct(array $alleleNames) {
        $this->alleleNames = $alleleNames;
    }

    /**
     * @param   array   $fGenes
     * @param   array   $mGenes
     *
     * @return  array
     */
    protected function calculateAllAlleles(array $fGenes, array $mGenes) : array
    {
        $cGenes = [];
        foreach ($this->alleleNames as $allele) {
            $cGenes[$allele] = $this->calculateSingleAllele(
                $fGenes[$allele], $mGenes[$allele]
            );
        }
        return $cGenes;
    }

    /**
     * @param   int $father
     * @param   int $mother
     *
     * @return  int
     */
    protected function calculateSingleAllele(int $father, int $mother) : int
    {
        $fGene = $this->getRandomGene($father);
        $mGene = $this->getRandomGene($mother);
        return ($fGene > $mGene) ? $mGene . $fGene : $fGene . $mGene;
    }

    /**
     * @param   int $allele
     *
     * @return  int
     */
    protected function getRandomGene(int $allele) : int
    {
        $genes = str_split($allele);
        $random = mt_rand(0,1);
        return (int)$genes[$random];
    }
}
