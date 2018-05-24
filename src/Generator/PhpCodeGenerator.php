<?php

namespace Chompy\Generator;

use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\Grammar\TokenInfo;
use Chompy\Generator\Options\CodeGeneratorOptions;
use Chompy\Generator\StateTable\State;
use Chompy\Generator\StateTable\StateTable;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\PrettyPrinter\Standard;
use PhpParser\PrettyPrinterAbstract;

final class PhpCodeGenerator implements CodeGeneratorInterface
{
    use CodeGeneratorWriteTrait;

    const VARIABLE_STATE_STACK = 'sts';
    const VARIABLE_OUTPUT_STACK = 'os';
    const VARIABLE_OFFSET = 'o';
    const VARIABLE_LENGTH = 'l';
    const VARIABLE_STRING = 'string';
    const VARIABLE_MATCH = 'm';
    const VARIABLE_REDUCE_INPUT_PREFIX = 'r';
    const VARIABLE_ERROR_LINES = 'els';
    const VARIABLE_ERROR_LINE = 'el';
    const VARIABLE_ERROR_COLUMN = 'ec';
    const VARIABLE_REDUCE_PARAM_PREFIX = 'p';

    const TOKEN_END = '$';

    const LABEL_STATE_PREFIX = 'st';
    const LABEL_REDUCE_GOTO_PREFIX = 'gt';

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
        $class = new Class_($options->getClassName(), ['flags' => Class_::MODIFIER_ABSTRACT]);

        // Add the parse method.
        $method = new ClassMethod('parse', ['flags' => Class_::MODIFIER_PUBLIC]);
        $method->stmts = $this->generateParserMethod($grammar, $stateTable);
        $method->params[] = new Param(new Variable(self::VARIABLE_STRING), null, 'string');
        $class->stmts[] = $method;

        // Add abstract functions for all the reduce functions.
        $reduceFunctionMaxArgs = [];
        $reduceFunctionMinArgs = [];
        foreach ($grammar->rules as $rule) {
            $argsCount = count($rule->input);
            if ($rule->reduceFunctionArgs !== null) {
                $argsCount = count($rule->reduceFunctionArgs);
            }
            if (isset ($reduceFunctionMaxArgs[$rule->reduceFunction])) {
                $reduceFunctionMaxArgs[$rule->reduceFunction] = max($argsCount, $reduceFunctionMaxArgs[$rule->reduceFunction]);
                $reduceFunctionMinArgs[$rule->reduceFunction] = min($argsCount, $reduceFunctionMinArgs[$rule->reduceFunction]);
            } else {
                $reduceFunctionMaxArgs[$rule->reduceFunction] = $argsCount;
                $reduceFunctionMinArgs[$rule->reduceFunction] = $argsCount;
            }
        }
        foreach ($reduceFunctionMaxArgs as $reduceFunction => $maxArgs) {
            $minArgs = $reduceFunctionMinArgs[$reduceFunction];
            $method = new ClassMethod($reduceFunction, ['flags' => Class_::MODIFIER_PROTECTED | Class_::MODIFIER_ABSTRACT, 'stmts' => null]);
            for ($i = 0; $i < $minArgs; $i++) {
                $method->params[] = new Param(new Variable(self::VARIABLE_REDUCE_PARAM_PREFIX . ($i + 1)), null);
            }
            $nullExpr = new Expr\ConstFetch(new Name('null'));
            for ($i = $minArgs; $i < $maxArgs; $i++) {
                $method->params[] = new Param(new Variable(self::VARIABLE_REDUCE_PARAM_PREFIX . ($i + 1)), $nullExpr);
            }
            $class->stmts[] = $method;
        }

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

        $output[] = new Stmt\Expression(
            new Assign(
                new Variable(new Name(self::VARIABLE_STATE_STACK)),
                new Array_([new ArrayItem(LNumber::fromString('0'))])
            )
        );

        $output[] = new Stmt\Expression(
            new Assign(
                new Variable(new Name(self::VARIABLE_OUTPUT_STACK)),
                new Array_()
            )
        );

        $output[] = new Stmt\Expression(
            new Assign(
                new Variable(new Name(self::VARIABLE_OFFSET)),
                LNumber::fromString('0')
            )
        );

        $output[] = new Stmt\Expression(
            new Assign(
                new Variable(new Name(self::VARIABLE_LENGTH)),
                new FuncCall(new Name('strlen'), [new Arg(new Variable(self::VARIABLE_STRING))])
            )
        );

        // Go to state 0.
        $output[] = new Stmt\Goto_(self::LABEL_STATE_PREFIX . '0');

        [$reduceGotoStmts, $gotoLabelMap] = $this->generateReduceGotoCode($stateTable);

        foreach (array_keys($stateTable->states) as $stateIndex) {
            $output = array_merge($output, $this->generateStateCode($grammar, $stateTable, $stateIndex, $gotoLabelMap));
        }

        $output = array_merge($output, $reduceGotoStmts);

        return $output;
    }

    /**
     * @param Grammar $grammar
     * @param StateTable $stateTable
     * @param int $stateIndex
     * @param array $gotoLabelMap
     *
     * @return Stmt[]
     */
    private function generateStateCode(Grammar $grammar, StateTable $stateTable, int $stateIndex, array $gotoLabelMap): array
    {
        $output = [];
        $output[] = new Stmt\Label(self::LABEL_STATE_PREFIX . $stateIndex);

        $state = $stateTable->states[$stateIndex];

        if (isset ($state->reduces['$'])) {
            $test = $this->generateEndOfStringTest();
            $if = new Stmt\If_($test);
            $if->stmts = $this->generateReduceCode($grammar, $stateTable, $state->reduces['$'], $gotoLabelMap);
            $output[] = $if;
        }

        $tokenCheckStmts = [];
        $tokenCheckIf = null;
        if ($state->shifts || array_diff_key($state->reduces, ['$' => null])) {
            // If we are going to check for more tokens, first check if we are at the end.
            $tokenCheckIf = new Stmt\If_(new Expr\BinaryOp\Greater(
                new Variable(self::VARIABLE_LENGTH),
                new Variable(self::VARIABLE_OFFSET)
            ));
        }

        foreach ($state->reduces as $token => $reduceRuleIndex) {
            if ($token === '$') {
                // Already handled above.
                continue;
            } else {
                [$test] = $this->generateTokenTest($grammar->tokens[$token]);
            }
            $if = new Stmt\If_($test);
            $if->stmts = $this->generateReduceCode($grammar, $stateTable, $reduceRuleIndex, $gotoLabelMap);
            $tokenCheckStmts[] = $if;
        }

        foreach ($state->shifts as $token => $shiftStateIndex) {
            if (!isset ($grammar->tokens[$token])) {
                throw new \InvalidArgumentException('Invalid token: ' . $token);
            }

            [$test, $matchExpr, $shiftLengthExpr] = $this->generateTokenTest($grammar->tokens[$token]);
            $if = new Stmt\If_($test);
            $if->stmts = $this->generateShiftCode($grammar, $stateTable, $shiftStateIndex, $matchExpr, $shiftLengthExpr);
            $tokenCheckStmts[] = $if;
        }

        if ($tokenCheckIf !== null) {
            $tokenCheckIf->stmts = $tokenCheckStmts;
            $output[] = $tokenCheckIf;
        } else {
            $output = array_merge($output, $tokenCheckStmts);
        }

        $output = array_merge($output, $this->generateErrorCode($grammar, $state));

        return $output;
    }

    /**
     * @param Grammar $grammar
     * @param StateTable $stateTable
     * @param int $toStateIndex
     * @param Expr $matchExpr
     * @param Expr $shiftLengthExpr
     *
     * @return Stmt[]
     */
    private function generateShiftCode(Grammar $grammar, StateTable $stateTable, int $toStateIndex, Expr $matchExpr, Expr $shiftLengthExpr): array
    {
        $output = [];

        // Push new state on the stack.
        $output[] = new Stmt\Expression(
            new Assign(
                new ArrayDimFetch(new Variable(self::VARIABLE_STATE_STACK)),
                new LNumber($toStateIndex, ['kind' => LNumber::KIND_DEC])
            )
        );

        // Push the match on the result stack.
        $output[] = new Stmt\Expression(
            new Assign(
                new ArrayDimFetch(new Variable(self::VARIABLE_OUTPUT_STACK)),
                $matchExpr
            )
        );

        $output[] = new Stmt\Expression(
            new Expr\AssignOp\Plus(
                new Variable(self::VARIABLE_OFFSET),
                $shiftLengthExpr
            )
        );

        $output[] = new Stmt\Goto_(self::LABEL_STATE_PREFIX . $toStateIndex);

        return $output;
    }

    /**
     * @param Grammar $grammar
     * @param StateTable $stateTable
     * @param int $reduceRuleIndex
     * @param array $gotoLabelMap
     *
     * @return Stmt[]
     */
    private function generateReduceCode(Grammar $grammar, StateTable $stateTable, int $reduceRuleIndex, array $gotoLabelMap): array
    {
        $output = [];

        $rule = $grammar->rules[$reduceRuleIndex];

        foreach (array_reverse(array_keys($rule->input)) as $reduceVarIndex) {
            $output[] = new Stmt\Expression(
                new Assign(
                    new Variable(self::VARIABLE_REDUCE_INPUT_PREFIX . $reduceVarIndex),
                    new FuncCall(new Name('array_pop'), [
                        new Arg(new Variable(self::VARIABLE_OUTPUT_STACK))
                    ])
                )
            );
        }

        if ($rule->reduceFunction) {
            $reduceFunctionArgs = $rule->reduceFunctionArgs === null
                ? array_keys($rule->input)
                : $rule->reduceFunctionArgs;

            $args = [];
            foreach ($reduceFunctionArgs as $reduceVarIndex) {
                $args[] = new Arg(new Variable(self::VARIABLE_REDUCE_INPUT_PREFIX . $reduceVarIndex));
            }
            $reduceData = new Expr\MethodCall(
                new Variable(new Name('this')),
                $rule->reduceFunction,
                $args
            );
        } else {
            $reduceData = new Expr\ConstFetch(new Name('null'));
        }

        if ($reduceRuleIndex === 0) {
            // Return here.
            $output[] = new Stmt\Return_($reduceData);
            return $output;
        }

        $output[] = new Stmt\Expression(
            new Assign(
                new ArrayDimFetch(new Variable(self::VARIABLE_OUTPUT_STACK)),
                $reduceData
            )
        );

        // Now pop the right number of states off the stack.
        for ($i = 0; $i < count($rule->input); $i++) {
            $output[] = new Stmt\Expression(
                new FuncCall(new Name('array_pop'), [
                    new Arg(new Variable(self::VARIABLE_STATE_STACK))
                ])
            );
        }

        $output[] = new Stmt\Goto_($gotoLabelMap[$rule->output]);

        return $output;
    }

    /**
     * @param TokenInfo $tokenInfo
     * @return array
     *   [Expr test, Expr matchExpr, Expr shiftOffsetExpr]
     */
    private function generateTokenTest(TokenInfo $tokenInfo)
    {
        switch ($tokenInfo->type) {
            case TokenInfo::TYPE_STRING:
                return [
                    new Identical(
                        new FuncCall(new Name('substr_compare'), [
                            new Variable(self::VARIABLE_STRING),
                            new String_($tokenInfo->pattern),
                            new Variable(self::VARIABLE_OFFSET),
                            new LNumber(strlen($tokenInfo->pattern), ['kind' => LNumber::KIND_DEC])
                        ]),
                        LNumber::fromString('0')
                    ),
                    new Array_([new ArrayItem(new String_($tokenInfo->pattern))]),
                    new LNumber(strlen($tokenInfo->pattern), ['kind' => LNumber::KIND_DEC])
                ];
            case TokenInfo::TYPE_REGEX:
                $pattern = '(' . $tokenInfo->pattern . ')ADs';
                return [
                    new FuncCall(new Name('preg_match'), [
                        new String_($pattern),
                        new Variable(self::VARIABLE_STRING),
                        new Variable(self::VARIABLE_MATCH),
                        LNumber::fromString('0'),
                        new Variable(self::VARIABLE_OFFSET),
                    ]),
                    new Variable(self::VARIABLE_MATCH),
                    new FuncCall(new Name('strlen'), [
                        new ArrayDimFetch(
                            new Variable(self::VARIABLE_MATCH),
                            LNumber::fromString('0')
                        )
                    ])
                ];
        }
    }

    /**
     * @return Expr
     */
    private function generateEndOfStringTest()
    {
        return new Identical(new Variable(self::VARIABLE_OFFSET), new Variable(self::VARIABLE_LENGTH));
    }

    /**
     * @param Grammar $grammar
     * @param State $state
     * @return Stmt[]
     */
    private function generateErrorCode(Grammar $grammar, State $state)
    {
        $output = [];

        $tokens = array_unique(array_merge(array_keys($state->shifts), array_keys($state->reduces)));
        $tokenDescriptions = [];
        foreach ($tokens as $token) {
            if ($token === '$') {
                $tokenDescriptions[] = 'end of string';
                continue;
            }
            $tokenInfo = $grammar->tokens[$token];
            switch ($tokenInfo->type) {
                case TokenInfo::TYPE_STRING:
                    $tokenDescriptions[] = str_replace(["\n", "\r", "\t", " "], ['\n', '\r', '\t', 'space'], $tokenInfo->pattern);
                    break;
                case TokenInfo::TYPE_REGEX:
                    $tokenDescriptions[] = $token . ' (' . $tokenInfo->pattern . ')';
                    break;
            }
        }

        if (count($tokenDescriptions) > 1) {
            $lastTokenDescription = array_pop($tokenDescriptions);
            $secondLastTokenDescription = array_pop($tokenDescriptions);
            $tokenDescriptions[] = $secondLastTokenDescription . ' or ' . $lastTokenDescription;
        }

        $output[] = new Stmt\Expression(
            new Assign(
                new Variable(self::VARIABLE_ERROR_LINES),
                new FuncCall(new Name('explode'), [
                    new String_("\n", ['kind' => String_::KIND_DOUBLE_QUOTED]),
                    new FuncCall(new Name('substr'), [
                        new Variable(self::VARIABLE_STRING),
                        LNumber::fromString('0'),
                        new Variable(self::VARIABLE_OFFSET)
                    ])
                ])
            )
        );
        $output[] = new Stmt\Expression(
            new Assign(
                new Variable(self::VARIABLE_ERROR_LINE),
                new FuncCall(new Name('count'), [new Variable(self::VARIABLE_ERROR_LINES)])
            )
        );
        $output[] = new Stmt\Expression(
            new Assign(
                new Variable(self::VARIABLE_ERROR_COLUMN),
                new Expr\BinaryOp\Plus(
                    new FuncCall(new Name('strlen'), [
                        new FuncCall(new Name('array_pop'), [
                            new Variable(self::VARIABLE_ERROR_LINES)
                        ])
                    ]),
                    LNumber::fromString('1')
                )
            )
        );

        $message = 'Expect ' . implode(', ', $tokenDescriptions) . ' at line ';

        $errorExpr = new Expr\BinaryOp\Concat(
            new Expr\BinaryOp\Concat(
                new Expr\BinaryOp\Concat(
                    new String_($message),
                    new Variable(self::VARIABLE_ERROR_LINE)
                ),
                new String_(', column ')
            ),
            new Variable(self::VARIABLE_ERROR_COLUMN)
        );

        $output[] = new Stmt\Throw_(
            new Expr\New_(new Name('\Exception'), [
                $errorExpr
            ])
        );

        return $output;
    }

    /**
     * @param StateTable $stateTable
     * @return array
     *   [Stmt[], array nonTerminalName => label]
     */
    private function generateReduceGotoCode(StateTable $stateTable)
    {
        $stmts = [];
        $gotoLabelMap = [];
        $labelIndex = 0;
        foreach ($stateTable->states as $state) {
            foreach (array_keys($state->gotos) as $nonTerminalKey) {
                if (isset ($gotoLabelMap[$nonTerminalKey])) {
                    continue;
                }
                $label = self::LABEL_REDUCE_GOTO_PREFIX . ($labelIndex++);
                $gotoLabelMap[$nonTerminalKey] = $label;

                $lastStateExpr = new ArrayDimFetch(
                    new Variable(self::VARIABLE_STATE_STACK),
                    new Expr\BinaryOp\Minus(
                        new FuncCall(new Name('count'), [
                            new Arg(new Variable(self::VARIABLE_STATE_STACK)),
                        ]),
                        LNumber::fromString('1')
                    )
                );

                $stmts[] = new Stmt\Label($label);
                $switch = new Stmt\Switch_($lastStateExpr, []);
                $stmts[] = $switch;
                foreach ($stateTable->states as $reduceStateIndex => $reduceState) {
                    if (!isset ($reduceState->gotos[$nonTerminalKey])) {
                        continue;
                    }
                    $case = new Stmt\Case_(new LNumber($reduceStateIndex, ['kind' => LNumber::KIND_DEC]));
                    $switch->cases[] = $case;
                    $case->stmts[] = new Stmt\Expression(
                        new Assign(
                            new ArrayDimFetch(
                                new Variable(self::VARIABLE_STATE_STACK)
                            ),
                            new LNumber($reduceState->gotos[$nonTerminalKey], ['kind' => LNumber::KIND_DEC])
                        )
                    );
                    $case->stmts[] = new Stmt\Goto_(self::LABEL_STATE_PREFIX . $reduceState->gotos[$nonTerminalKey]);
                }
            }
        }

        return [$stmts, $gotoLabelMap];
    }
}
