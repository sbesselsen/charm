<?php

namespace Charm\Generator\Definition\PicoGram;

use Charm\Generator\Grammar\Grammar;
use Charm\Generator\Grammar\OperatorInfo;
use Charm\Generator\Grammar\Reduce\CallReduceAction;
use Charm\Generator\Grammar\Rule;
use Charm\Generator\Grammar\TokenInfo;

final class PicoGramParser extends AbstractPicoGramParser
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

    protected function reduceRuleDef($output, $p2, $p3, $p4, $sequence, $p6, $p7, $p8, $reduceFunction, $p10, $p11)
    {
        return [new Rule($output[0], $sequence, new CallReduceAction($reduceFunction[0]))];
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
}
