<?php

namespace Chompy\Generator;

use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\Options\CodeGeneratorOptions;
use Chompy\Generator\StateTable\StateTable;

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
     */
    public function generate(Grammar $grammar, StateTable $stateTable, CodeGeneratorOptions $options = null): string;

    /**
     * @param string $path
     * @param Grammar $grammar
     * @param StateTable $stateTable
     * @param CodeGeneratorOptions|null $options
     */
    public function write(string $path, Grammar $grammar, StateTable $stateTable, CodeGeneratorOptions $options = null): void;
}
