<?php

namespace Chompy\Tokenizer;

class TokenizerPosition
{
    /**
     * The line number.
     *
     * @var int
     *   The line number.
     */
    public $line;

    /**
     * The column within the current line.
     *
     * @var int
     *   The column.
     */
    public $column;

    /**
     * The offset within the entire string.
     *
     * @var int
     *   The offset.
     */
    public $offset;

    /**
     * TokenizerPosition constructor.
     * @param int $line
     *   The line number.
     * @param int $column
     *   The column within the current line.
     * @param int $offset
     *   The offset within the entire string.
     */
    public function __construct(int $line, int $column, int $offset)
    {
        $this->line = $line;
        $this->column = $column;
        $this->offset = $offset;
    }

    /**
     * Calculate a position from a byte offset within a specified string.
     *
     * @param string $string
     * @param int $offset
     *
     * @return TokenizerPosition
     */
    public static function fromOffsetInString(string $string, int $offset)
    {
        $prefix = substr($string, 0, $offset);
        $lines = explode("\n", $prefix);
        $lastLine = array_pop($lines);
        return new TokenizerPosition(count($lines) + 1, strlen($lastLine) + 1, $offset);
    }
}
