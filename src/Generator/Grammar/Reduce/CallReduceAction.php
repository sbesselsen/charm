<?php

namespace Charm\Generator\Grammar\Reduce;

final class CallReduceAction extends ReduceAction
{
    /**
     * The method to call.
     *
     * @var string
     *   The reduce function.
     */
    public $methodName;

    /**
     * The way the input should be passed to the reduce method, if different from the normal order.
     *
     * @var null|array
     *   The mapping.
     */
    public $argsMapping = null;

    /**
     * CallReduceAction constructor.
     * @param string $methodName
     * @param array|null $argsMapping
     */
    public function __construct(string $methodName, array $argsMapping = null)
    {
        $this->methodName = $methodName;
        $this->argsMapping = $argsMapping;
    }
}
