<?php

namespace Chompy;

use Chompy\Tokenizer\TokenizerPosition;
use Throwable;

class ParseException extends \Exception
{
    /**
     * The position where the exception occurred.
     *
     * @var TokenizerPosition
     *   The position.
     */
    private $position;

    /**
     * Get the position where the exception occurred.
     *
     * @return TokenizerPosition
     */
    public function getPosition(): TokenizerPosition
    {
        return $this->position;
    }

    /**
     * ParseException constructor.
     * @param string $message
     * @param TokenizerPosition $position
     *   The position where the exception occurred.
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = "",
        TokenizerPosition $position,
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->position = $position;
    }

    /**
     * @param string $string
     * @param int $offset
     *
     * @return ParseException
     */
    public static function unexpectedInput(string $string, int $offset)
    {
        $position = TokenizerPosition::fromOffsetInString($string, $offset);
        $input = substr($string, $offset, 1);
        return new static(
            "Unexpected input at line {$position->line}, column {$position->column}: {$input}",
            $position
        );
    }

}