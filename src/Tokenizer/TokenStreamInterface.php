<?php

namespace Chompy\Tokenizer;

interface TokenStreamInterface
{
    /**
     * Shift one token forward.
     */
    public function next(): void;

    /**
     * Read the current token.
     *
     * @return null|array
     *   Null if no more tokens, [token_name, token_string] otherwise.
     */
    public function current();

    /**
     * Get the current position of the tokenizer.
     *
     * @return TokenizerPosition
     */
    public function getPosition(): TokenizerPosition;
}
