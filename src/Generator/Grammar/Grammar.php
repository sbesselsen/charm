<?php

namespace Chompy\Generator\Grammar;

class Grammar
{
    /**
     * The tokens.
     *
     * @var TokenInfo[]
     *   Array of (token name => TokenInfo)
     */
    public $tokens = [];

    /**
     * The rules.
     *
     * @var Rule[]
     *   The rules.
     */
    public $rules = [];

    /**
     * Operator info.
     *
     * @var OperatorInfo[]
     *   Array of (operator name => OperatorInfo)
     */
    public $operators = [];
}
