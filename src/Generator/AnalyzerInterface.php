<?php

namespace Charm\Generator;

use Charm\Generator\Grammar\Grammar;
use Charm\Generator\StateTable\StateTable;

interface AnalyzerInterface
{
    /**
     * @param Grammar $grammar
     *
     * @return StateTable
     * @throws \Exception
     *   If the grammar is invalid.
     */
    public function generateStateTable(Grammar $grammar): StateTable;
}
