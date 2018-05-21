<?php

namespace Chompy\Generator\Analysis;

class ItemSet
{
    /**
     * The items.
     *
     * @var Item[]
     *   The items.
     */
    public $items = [];

    /**
     * The additional items from closure of the item set.
     *
     * @var Item[]
     *   The additional items.
     */
    public $closureItems = [];
}
