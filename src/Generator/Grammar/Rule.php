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
     * Rule constructor.
     * @param string $output
     * @param array $input
     * @param string $reduceFunction
     */
    public function __construct(string $output, array $input, string $reduceFunction)
    {
        $this->output = $output;
        $this->input = $input;
        $this->reduceFunction = $reduceFunction;
    }
}
