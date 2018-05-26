<?php

namespace Charm\Generator\Grammar;

class WhitespaceInfo
{
    /**
     * The whitespace token name.
     *
     * @var string
     *   The token nae.
     */
    public $token;

    /**
     * Whether whitespace is allowed at the start of strings.
     *
     * @var bool
     */
    public $allowAtStart;

    /**
     * WhitespaceInfo constructor.
     * @param string $token
     * @param bool $allowAtStart
     */
    public function __construct(string $token, bool $allowAtStart)
    {
        $this->token = $token;
        $this->allowAtStart = $allowAtStart;
    }
}
