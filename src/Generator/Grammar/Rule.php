<?php

namespace Chompy\Generator\Grammar;

use Chompy\Generator\Grammar\Reduce\ReduceAction;

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
     * The reduce action.
     *
     * @var ReduceAction
     *   The reduce action.
     */
    public $reduceAction;

    /**
     * Rule constructor.
     * @param string $output
     * @param array $input
     * @param ReduceAction $reduceAction
     */
    public function __construct(string $output, array $input, ReduceAction $reduceAction)
    {
        $this->output = $output;
        $this->input = $input;
        $this->reduceAction = $reduceAction;
    }
}
