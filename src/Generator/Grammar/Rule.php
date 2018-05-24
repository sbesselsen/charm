<?php

namespace Chompy\Generator\Grammar;

class Rule
{
    /**
     * The input of the rule.
     *
     * @var array
     *   The input.
     */
    public $input = [];

    /**
     * The output.
     *
     * @var string
     *   The output.
     */
    public $output;

    /**
     * The reduce function.
     *
     * @var string
     *   The reduce function.
     */
    public $reduceFunction;

    /**
     * The way the input should be passed to the reduce function, if different from the normal order.
     *
     * @var null|array
     *   The mapping.
     */
    public $reduceFunctionArgs = null;

    /**
     * Rule constructor.
     * @param string $output
     * @param array $input
     * @param string $reduceFunction
     * @param array|null $reduceFunctionArgs
     */
    public function __construct(string $output, array $input, string $reduceFunction, array $reduceFunctionArgs = null)
    {
        $this->output = $output;
        $this->input = $input;
        $this->reduceFunction = $reduceFunction;
        $this->reduceFunctionArgs = $reduceFunctionArgs;
    }
}
