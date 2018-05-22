<?php

namespace Chompy\Generator;

use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\Options\CodeGeneratorOptions;

class ParserGenerator implements ParserGeneratorInterface
{
    /**
     * The analyzer.
     *
     * @var AnalyzerInterface
     *   The analyzer.
     */
    private $analyzer;

    /**
     * The code generator.
     *
     * @var CodeGeneratorInterface
     *   The code generator.
     */
    private $codeGenerator;

    /**
     * ParserGenerator constructor.
     * @param AnalyzerInterface $analyzer
     * @param CodeGeneratorInterface $codeGenerator
     */
    public function __construct(AnalyzerInterface $analyzer, CodeGeneratorInterface $codeGenerator)
    {
        $this->analyzer = $analyzer;
        $this->codeGenerator = $codeGenerator;
    }

    public function createCodeGeneratorOptions(): CodeGeneratorOptions
    {
        return $this->codeGenerator->createOptions();
    }

    public function generate(Grammar $grammar, CodeGeneratorOptions $options = null): string
    {
        $stateTable = $this->analyzer->generateStateTable($grammar);
        return $this->codeGenerator->generate($grammar, $stateTable, $options);
    }

    public function write(string $path, Grammar $grammar, CodeGeneratorOptions $options = null): void
    {
        $stateTable = $this->analyzer->generateStateTable($grammar);
        $this->codeGenerator->write($path, $grammar, $stateTable, $options);
    }

    /**
     * @return ParserGeneratorInterface
     */
    public static function defaultGenerator()
    {
        return new ParserGenerator(
            new LalrAnalyzer(),
            new PhpCodeGenerator()
        );
    }
}
