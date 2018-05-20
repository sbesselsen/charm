<?php

namespace Chompy\Generator\StateTable;

class State
{
    /**
     * The shifts.
     *
     * @var array
     *   The shifts (token => state index).
     */
    public $shifts = [];

    /**
     * The reduces.
     *
     * @var array
     *   The reduces (token => rule index).
     */
    public $reduces = [];

    /**
     * The gotos.
     *
     * @var
     *   The gotos (nonterminal name => state index).
     */
    public $gotos = [];
}
