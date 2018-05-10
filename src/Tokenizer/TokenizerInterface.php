<?php

namespace Chompy\Tokenizer;

interface TokenizerInterface
{
    /**
     * Tokenizing a string.
     *
     * @param string $string
     *
     * @return TokenStreamInterface
     *
     * @throws TokenizerException
     *   If a part of the string can't be tokenized.
     */
    public function tokenize(string $string): TokenStreamInterface;
}
