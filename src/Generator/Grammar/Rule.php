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
}
