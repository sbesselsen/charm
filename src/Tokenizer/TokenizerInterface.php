<?php

namespace Chompy\Tokenizer;

interface TokenizerInterface
{
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
