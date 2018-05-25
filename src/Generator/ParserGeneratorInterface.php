<?php

namespace Charm\Generator;

use Charm\Generator\Grammar\Grammar;
use Charm\Generator\Options\CodeGeneratorOptions;

interface ParserGeneratorInterface
{
    /**
     *
     * @return CodeGeneratorOptions
     */
    public function createCodeGeneratorOptions(): CodeGeneratorOptions;

    /**
     * @param Grammar $grammar
     * @param CodeGeneratorOptions|null $options
     *
     * @return string
     *
     * @throws \Exception
     *   If the grammar is inconsistent.
     */
    public function generate(Grammar $grammar, CodeGeneratorOptions $options = null): string;

    /**
     * @param string $path
     * @param Grammar $grammar
     * @param CodeGeneratorOptions|null $options
     *
     * @throws \Exception
     *   If the grammar is inconsistent.
     */
    public function write(string $path, Grammar $grammar, CodeGeneratorOptions $options = null): void;
}
