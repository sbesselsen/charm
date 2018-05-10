<?php

namespace Chompy\Parser;

use Chompy\Node\Node;
use Chompy\ParseException;

interface ParserInterface
{
    /**
     * Parse a string.
     *
     * @param string $string
     *   The input string.
     *
     * @return Node
     *   The output node.
     *
     * @throws ParseException
     *   If there is an error parsing the input.
     */
    public function parse(string $string): Node;
}
