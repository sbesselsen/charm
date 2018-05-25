<?php

namespace Chompy\Generator\Grammar\Reduce;

final class CopyReduceAction extends ReduceAction
{
    /**
     * The element index.
     *
     * @var int
     *   The element index.
     */
    public $elementIndex;

    /**
     * CopyReduceAction constructor.
     * @param int $elementIndex
     */
    public function __construct(int $elementIndex)
    {
        $this->elementIndex = $elementIndex;
    }
}
