<?php

namespace Chompy\Tokenizer;

use Chompy\ParseException;

final class RegexTokenizer implements TokenizerInterface
{
    /**
     * The patterns, grouped by prefix bytes.
     *
     * @var array
     *   The patterns.
     */
    private $patternsByPrefix = [];

    /**
     * RegexTokenizer constructor.
     * @param array $tokens
     */
    public function __construct(array $tokens)
    {
        $patternPartsByPrefix = [];
        for ($i = 0; $i < 255; $i++) {
            $patternPartsByPrefix[chr($i)] = [];
        }

        foreach ($tokens as $name => $pattern) {
            $namedPattern = '(?<' . preg_quote($name) . '>' . $pattern . ')';
            $prefix = $this->getPrefix($pattern);

            if ($prefix === null) {
                // Add complex patterns for every prefix.
                foreach ($patternPartsByPrefix as $prefix => $_) {
                    $patternPartsByPrefix[$prefix][] = $namedPattern;
                }
            } else {
                $patternPartsByPrefix[$prefix][] = $namedPattern;
            }
        }

        foreach ($patternPartsByPrefix as $prefix => $patternParts) {
            if ($patternParts) {
                $this->patternsByPrefix[$prefix] = '('.implode('|', $patternParts).')ADs';
            }
        }
    }

    public function tokenize(string $string): array
    {
        $offset = 0;
        $normalizedMatches = [];
        $strlen = strlen($string);
        while ($offset < $strlen) {
            $prevOffset = $offset;
            $prefix = $string{$offset};
            $pattern = $this->patternsByPrefix[$prefix];
            if (!preg_match($pattern, $string, $match, 0, $offset)) {
                break;
            }
            foreach ($match as $k => $matchString) {
                if (is_int($k) || $matchString === '') {
                    continue;
                }
                $normalizedMatches[] = [$k, $matchString, $offset];
                $offset += strlen($matchString);
                break;
            }
            if ($offset === $prevOffset) {
                break;
            }
        }

        if ($offset < $strlen) {
            throw ParseException::unexpectedInput($string, $offset);
        }

        return $normalizedMatches;
    }

    /**
     * Get a prefix character for this pattern. The pattern will only be tried when the string starts with it.
     *
     * @param string $pattern
     *
     * @return string|null
     *   The prefix, or null if the pattern should be tried for every string.
     */
    private function getPrefix(string $pattern)
    {
        $prefix = substr($pattern, 0, 1);

        if ($prefix === '(' || $prefix === '[') {
            return null;
        }

        if ($prefix === '\\') {
            $prefixMappings = ['n' => "\n", 'r' => "\r", 't' => "\t", '[' => '[', '(' => '('];
            $escapedPrefix = substr($pattern, 1, 1);
            return $prefixMappings[$escapedPrefix] ?? null;
        }

        return $prefix;
    }
}
