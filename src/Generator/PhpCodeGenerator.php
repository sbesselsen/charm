<?php

namespace Chompy\Generator;

use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\Options\CodeGeneratorOptions;
use Chompy\Generator\StateTable\StateTable;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\PrettyPrinter\Standard;
use PhpParser\PrettyPrinterAbstract;

final class PhpCodeGenerator implements CodeGeneratorInterface
{
    use CodeGeneratorWriteTrait;

    /**
     * The pretty printer.
     *
     * @var PrettyPrinterAbstract
     *   The pretty printer.
     */
    private $prettyPrinter;

    public function __construct()
    {
        $this->prettyPrinter = new Standard();
    }

    /**
     * @param PrettyPrinterAbstract $prettyPrinter
     *
     * @return $this
     */
    public function setPrettyPrinter(PrettyPrinterAbstract $prettyPrinter)
    {
        $this->prettyPrinter = $prettyPrinter;
        return $this;
    }

    public function createOptions(): CodeGeneratorOptions
    {
        return (new CodeGeneratorOptions())
            ->setClassName('AbstractParser')
            ->setNamespace('');
    }

    public function generate(Grammar $grammar, StateTable $stateTable, CodeGeneratorOptions $options = null): string
    {
        if ($options === null) {
            $options = $this->createOptions();
        }

        $statements = [];
        if ($namespace = $options->getNamespace()) {
            $statements[] = new Namespace_(new Name($namespace));
        }
        $class = new Class_(new Identifier($options->getClassName()), ['flags' => Class_::MODIFIER_ABSTRACT]);
        $method = new ClassMethod(new Identifier('parse'), ['flags' => Class_::MODIFIER_PUBLIC]);
        $method->stmts = $this->generateParserMethod($grammar, $stateTable);
        $method->params[] = new Param(new Variable('string'), null, 'string');;
        $class->stmts[] = $method;
        $statements[] = $class;

        return $this->prettyPrinter->prettyPrintFile($statements);
    }

    /**
     * @param Grammar $grammar
     * @param StateTable $stateTable
     *
     * @return Stmt[]
     */
    private function generateParserMethod(Grammar $grammar, StateTable $stateTable): array
    {
        $output = [];

        return $output;
    }
}
