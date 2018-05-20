<?php

namespace Chompy\Generator\Grammar;

class OperatorInfo
{
    const ASSOC_NONE = 0;
    const ASSOC_LEFT = 1;
    const ASSOC_RIGHT = 2;

    /**
     * The precedence.
     *
     * @var int
     *   The precedence.
     */
    public $precedence;

    /**
     * The associativity.
     *
     * @var int
     *   One of InfixOperator::ASSOC_*.
     */
    public $associativity;
}
