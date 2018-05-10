<?php

namespace Chompy\Parser;

use Chompy\Node\Node;
use Chompy\ParseException;
use Chompy\Tokenizer\TokenizerInterface;

abstract class RecursiveParser implements ParserInterface
{
    /**
     * The tokens.
     *
     * @var array|null
     *   The tokens.
     */
    private $tokens;

    /**
     * The current token index.
     *
     * @var int
     *   The index.
     */
    private $tokenIndex;

    /**
     * The string.
     *
     * @var string
     *   The string.
     */
    private $string;

    /**
     * Stack of pushed states.
     *
     * @var array
     *   The stack.
     */
    private $stateStack;

    /**
     * The tokenizer.
     *
     * @var TokenizerInterface
     *   The tokenizer.
     */
    private $tokenizer;

    public function __construct()
    {
        $this->tokenizer = $this->createTokenizer();
    }

    public function parse(string $string): Node
    {
        $this->tokens = $this->tokenizer->tokenize($string);
        $this->tokenIndex = 0;
        $this->string = $string;
        $this->stateStack = [];

        return $this->parseMain();
    }

    /**
     * Create a tokenizer.
     *
     * @return TokenizerInterface
     */
    protected abstract function createTokenizer(): TokenizerInterface;

    /**
     * Parse the main element.
     *
     * @return Node
     *   The parsed node.
     *
     * @throws ParseException
     *   If the string can't be parsed.
     */
    protected abstract function parseMain(): Node;

    /**
     * Push the current state.
     */
    protected function push()
    {
        $this->stateStack[] = $this->tokenIndex;
    }

    /**
     * Pop the current state.
     */
    protected function pop()
    {
        if (!$this->stateStack) {
            throw new \LogicException('Cannot pop further');
        }
        $this->tokenIndex = array_pop($this->stateStack);
    }

    /**
     * Peek at the current token.
     *
     * @return array|null
     */
    protected function peek()
    {
        return $this->tokens[$this->tokenIndex] ?? null;
    }

    /**
     * Shift one token ahead.
     */
    protected function shift()
    {
        return $this->tokenIndex++;
    }

    /**
     * Consume the specified token.
     *
     * @param string $tokenName
     * @return array
     *   The token.
     *
     * @throws ParseException
     *   If the token is not found at the current position.
     */
    protected function consume(string $tokenName): array
    {
        if (!isset($this->tokens[$this->tokenIndex])) {
            throw ParseException::unexpectedEndOfInput($this->string);
        }

        if ($this->tokens[$this->tokenIndex][TokenizerInterface::TOKEN_TYPE] !== $tokenName) {
            throw ParseException::unexpectedInput(
                $this->string,
                $this->tokens[$this->tokenIndex][TokenizerInterface::TOKEN_OFFSET]
            );
        }

        return $this->tokens[$this->tokenIndex++];
    }

    /**
     * Skip a token.
     *
     * @param string $tokenName
     * @return bool
     *   Whether a token was skipped.
     */
    protected function skip(string $tokenName): bool
    {
        if (!isset($this->tokens[$this->tokenIndex])) {
            return false;
        }
        if ($this->tokens[$this->tokenIndex][TokenizerInterface::TOKEN_TYPE] !== $tokenName) {
            return false;
        }

        $this->tokenIndex++;

        return true;
    }

    /**
     * Check if we are at the end of the string.
     *
     * @return bool
     *   Whether we are at the end.
     */
    protected function isAtEnd(): bool
    {
        return !isset($this->tokens[$this->tokenIndex]);
    }

    /**
     * @return ParseException
     */
    protected function unexpected()
    {
        if (isset($this->tokens[$this->tokenIndex])) {
            return ParseException::unexpectedInput(
                $this->string,
                $this->tokens[$this->tokenIndex][TokenizerInterface::TOKEN_OFFSET]
            );
        }
        return ParseException::unexpectedEndOfInput($this->string);
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 8) === 'tryParse') {
            $method = 'parse'.substr($name, 8);

            return call_user_func_array([$this, $method], $arguments);
        }
        throw new \BadMethodCallException('Undefined method: '.$name);
    }

}
