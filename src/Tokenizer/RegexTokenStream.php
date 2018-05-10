<?php

namespace Chompy\Tokenizer;

final class RegexTokenStream implements TokenStreamInterface
{
    /**
     * The source string.
     *
     * @var string
     *   The source string.
     */
    private $sourceString;

    /**
     * The tokens.
     *
     * @var array
     *   The tokens.
     */
    private $tokens;

    /**
     * The index within the token array.
     *
     * @var int
     *   The index.
     */
    private $index = 0;

    public function __construct(string $sourceString, array $tokens)
    {
        $this->sourceString = $sourceString;
        $this->tokens = $tokens;
    }

    public function next(): void
    {
        $this->index++;
    }

    public function current()
    {
        return $this->tokens[$this->index] ?? null;
    }

    public function getPosition(): TokenizerPosition
    {
        if ($this->index === 0) {
            $offset = 0;
        }
        elseif (isset ($this->tokens[$this->index])) {
            $offset = $this->tokens[$this->index - 1][2];
        }
        else {
            // We are at the end of the string.
            $offset = strlen($this->sourceString);
        }

        return TokenizerPosition::fromOffsetInString($this->sourceString, $offset);
    }
}
