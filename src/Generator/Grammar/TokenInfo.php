<?php

namespace Charm\Generator\Grammar;

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

    /**
     * Whether this token is whitespace.
     *
     * @var bool
     *   True if the token is whitespace.
     */
    public $isWhitespace;

    /**
     * TokenInfo constructor.
     * @param int $type
     * @param string $pattern
     * @param bool $isWhitespace
     */
    public function __construct(int $type, string $pattern, bool $isWhitespace = false)
    {
        $this->type = $type;
        $this->pattern = $pattern;
        $this->isWhitespace = $isWhitespace;
    }
}
