<?php

namespace Chompy\Tokenizer;

use Chompy\ParseException;

final class RegexTokenizer implements TokenizerInterface
{
    /**
     * The pattern.
     *
     * @var string
     *   The pattern.
     */
    private $pattern;

    /**
     * RegexTokenizer constructor.
     * @param array $tokens
     */
    public function __construct(array $tokens)
    {
        $patternParts = [];
        foreach ($tokens as $name => $pattern) {
            $patternParts[] = '(?<' . preg_quote($name) . '>' . $pattern . ')';
        }
        $this->pattern = '(' . implode('|', $patternParts) . ')ADs';
    }

    public function tokenize(string $string): array
    {
        $offset = 0;
        $normalizedMatches = [];
        while (preg_match($this->pattern, $string, $match, 0, $offset)) {
            foreach ($match as $k => $matchString) {
                if (is_int($k) || $matchString === '') {
                    continue;
                }
                $normalizedMatches[] = [$k, $matchString, $offset];
                $offset += strlen($matchString);
                break;
            }
        }

        if ($offset < strlen($string)) {
            throw ParseException::unexpectedInput($string, $offset);
        }

        return $normalizedMatches;
    }
}
