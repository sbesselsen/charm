<?php

namespace Charm\Generator;

use Charm\Generator\Grammar\Grammar;
use Charm\Generator\Options\CodeGeneratorOptions;
use Charm\Generator\StateTable\StateTable;

trait CodeGeneratorWriteTrait
{
    public function write(string $path, Grammar $grammar, StateTable $stateTable, CodeGeneratorOptions $options = null): void
    {
        file_put_contents($path, $this->generate($grammar, $stateTable, $options));
    }
}
