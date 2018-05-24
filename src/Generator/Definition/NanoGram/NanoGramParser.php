<?php

namespace Chompy\Generator\Definition\NanoGram;

use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\Grammar\OperatorInfo;
use Chompy\Generator\Grammar\Rule;
use Chompy\Generator\Grammar\TokenInfo;

final class NanoGramParser extends AbstractNanoGramParser
{
    protected function reduceGrammar($items)
    {
        $grammar = new Grammar();
        foreach ($items as $item) {
            if ($item === null) {
                continue;
            }
            [$def] = $item;
            if ($def instanceof TokenInfo) {
                $grammar->tokens[$item[1]] = $def;
            } elseif ($def instanceof OperatorInfo) {
                $grammar->operators[$item[1]] = $def;
            } else {
                $grammar->rules[] = $def;
            }
        }
        return $grammar;
    }

    protected function reduceIdentity($p1)
    {
        return $p1;
    }

    protected function reduceComment($p1)
    {
        return null;
    }

    protected function reduceArrayOf($p1)
    {
        return [$p1];
    }

    protected function reduceItems($p1, $p2, $p3 = null)
    {
        if ($p3 !== null) {
            $p1[] = $p3;
        }
        return $p1;
    }

    protected function reduceTokenDef($type, $p2, $name, $p4, $pattern)
    {
        $patternData = $pattern[0];
        if (isset($type[1]) && $type[1] === 'escaped') {
            $patternData = str_replace(['\n', '\r', '\t', '\s'], ["\n", "\r", "\t", ' '], $patternData);
        }
        return [new TokenInfo($type[0] === 'token' ? TokenInfo::TYPE_STRING : TokenInfo::TYPE_REGEX, $patternData), $name[0]];
    }

    protected function reduceOperatorDef($p1, $p2, $name, $p4, $precedence, $p6 = null, $assoc = null)
    {
        $assocType = null;
        if ($assoc !== null) {
            switch ($assoc) {
                case 'left':
                    $assocType = OperatorInfo::ASSOC_LEFT;
                    break;
                case 'right':
                    $assocType = OperatorInfo::ASSOC_RIGHT;
                    break;
                case 'nonassoc':
                    $assocType = OperatorInfo::ASSOC_NONE;
                    break;
            }
        }
        return [new OperatorInfo((int)$precedence[0], $assocType), $name[0]];
    }

    protected function reduceRuleDef($output, $p2, $p3, $p4, $sequence, $p6, $p7, $p8, $reduceExpression, $p10, $p11)
    {
        [$reduceFunction, $reduceArgs] = $reduceExpression;

        return [new Rule($output[0], $sequence, $reduceFunction, $reduceArgs)];
    }

    protected function reduceSequenceItems($p1, $p2, $p3)
    {
        $p1[] = $p3[0];
        return $p1;
    }

    protected function reduceEscapedTokenType($p1, $p2, $p3)
    {
        return ['token', 'escaped'];
    }

    protected function reduceFunctionReduceExpression($name, $p2 = null, $args = null, $p4 = null)
    {
        return [$name[0], $args];
    }

    protected function reduceExpressionArgs($args, $p2, $p3, $arg)
    {
        $args[] = $arg;
        return $args;
    }

    protected function reduceExpressionPointer($p1)
    {
        return $p1[1];
    }

}
