<?php

namespace Chompy\Tokenizer;

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

    public function tokenize(string $string): TokenStreamInterface
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
                    throw $this->unexpectedInputException($string, $offset);
                }
                $offset += strlen($matchString);
                $normalizedMatches[] = [$k, $matchString, $offset];
                break;
            }
        }

        if ($offset < strlen($string)) {
            throw $this->unexpectedInputException($string, $offset);
        }

        return new RegexTokenStream($string, $normalizedMatches);
    }

    /**
     * @param string $string
     * @param int $offset
     *
     * @return TokenizerException
     */
    private function unexpectedInputException(string $string, int $offset)
    {
        $position = TokenizerPosition::fromOffsetInString($string, $offset);
        $input = substr($string, $offset, 1);
        return new TokenizerException(
            "Unexpected input at line {$position->line}, column {$position->column}: {$input}",
            $position
        );
    }
}
