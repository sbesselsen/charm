<?php

namespace Chompy\Generator;

use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\StateTable\StateTable;

interface AnalyzerInterface
{
    /**
     * @param Grammar $grammar
     *
     * @return StateTable
     */
    public function generateStateTable(Grammar $grammar): StateTable;
}
