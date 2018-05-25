<?php

namespace Charm\Generator;

use Charm\Generator\Grammar\Grammar;
use Charm\Generator\Options\CodeGeneratorOptions;
use Charm\Generator\StateTable\StateTable;

interface CodeGeneratorInterface
{
    /**
     *
     * @return CodeGeneratorOptions
     */
    public function createOptions(): CodeGeneratorOptions;

    /**
     * @param Grammar $grammar
     * @param StateTable $stateTable
     * @param CodeGeneratorOptions|null $options
     *
     * @return string
     *
     * @throws \Exception
     *   If the grammar has inconsistencies.
     */
    public function generate(Grammar $grammar, StateTable $stateTable, CodeGeneratorOptions $options = null): string;

    /**
     * @param string $path
     * @param Grammar $grammar
     * @param StateTable $stateTable
     * @param CodeGeneratorOptions|null $options
     *
     * @throws \Exception
     *   If the grammar has inconsistencies.
     */
    public function write(string $path, Grammar $grammar, StateTable $stateTable, CodeGeneratorOptions $options = null): void;
}
