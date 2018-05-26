<?php

namespace Charm\Generator\Grammar;

class TokenInfo
{
    const TYPE_STRING = 0;
    const TYPE_REGEX = 1;
    const TYPE_CHARS = 2;

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

    /**
     * Is this an exact token, e.g. one that does not support whitespace or other normalizing features?
     *
     * @var bool
     *   True if the token is exact.
     */
    public $exact;

    /**
     * TokenInfo constructor.
     * @param int $type
     * @param string $pattern
     * @param bool $exact
     */
    public function __construct(int $type, string $pattern, bool $exact)
    {
        $this->type = $type;
        $this->pattern = $pattern;
        $this->exact = $exact;
    }
}
