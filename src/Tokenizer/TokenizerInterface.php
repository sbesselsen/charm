<?php

namespace Chompy\Tokenizer;

interface TokenizerInterface
{
    const TOKEN_TYPE = 0;

    const TOKEN_STRING = 1;

    const TOKEN_OFFSET = 2;

    /**
     * Tokenizing a string.
     *
     * @param string $string
     *
     * @return array
     *   An array of tokens, where each token has the format [token_type, token_string, offset].
     *
     * @throws \Chompy\ParseException
     *   If a part of the string can't be tokenized.
     */
    public function tokenize(string $string): array;
}
