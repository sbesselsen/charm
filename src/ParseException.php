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
     * @param int $previewLength
     *
     * @return ParseException
     */
    public static function unexpectedInput(string $string, int $offset, int $previewLength = 30)
    {
        $position = TokenizerPosition::fromOffsetInString($string, $offset);
        $input = substr($string, $offset, $previewLength);
        if (strlen($string) > $offset + $previewLength) {
            $input .= '...';
        }
        return new static(
            "Unexpected input at line {$position->line}, column {$position->column}: {$input}",
            $position
        );
    }

    /**
     * @param string $string
     *
     * @return ParseException
     */
    public static function unexpectedEndOfInput(string $string)
    {
        $position = TokenizerPosition::fromOffsetInString($string, strlen($string));
        return new static(
            "Unexpected end of input at line {$position->line}, column {$position->column}",
            $position
        );
    }

}
