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
        preg_match_all(
            $this->pattern,
            $string,
            $matches,
            PREG_SET_ORDER | PREG_OFFSET_CAPTURE
        );

        // Now normalize the matches.
        $normalizedMatches = [];
        $offset = 0;
        foreach ($matches as $index => $match) {
            foreach ($match as $k => $v) {
                if (is_int($k) || $v[1] === -1) {
                    continue;
                }
                [$matchString, $matchOffset] = $v;
                if ($matchOffset > $offset) {
                    throw ParseException::unexpectedInput($string, $offset);
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
