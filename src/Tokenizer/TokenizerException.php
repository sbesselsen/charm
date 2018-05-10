<?php

namespace Chompy\Tokenizer;

use Throwable;

class TokenizerException extends \Exception
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
     * TokenizerException constructor.
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
}
