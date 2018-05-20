<?php

namespace Chompy\Generator\Grammar;

class TokenInfo
{
    const TYPE_STRING = 0;
    const TYPE_REGEX = 1;

    /**
     * The type.
     *
     * @var int
     *   One of TokenInfo::TYPE_*.
     */
    public $type;

    /**
     * The pattern.
     *
     * @var string
     *   The pattern.
     */
    public $pattern;
}
