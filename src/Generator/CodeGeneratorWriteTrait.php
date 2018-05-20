<?php

namespace Chompy\Generator;

use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\Options\CodeGeneratorOptions;
use Chompy\Generator\StateTable\StateTable;

trait CodeGeneratorWriteTrait
{
    public function write(string $path, Grammar $grammar, StateTable $stateTable, CodeGeneratorOptions $options = null): void
    {
        file_put_contents($path, $this->generate($grammar, $stateTable, $options));
    }
}
