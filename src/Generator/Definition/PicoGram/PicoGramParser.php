<?php

namespace Chompy\Generator\Definition\PicoGram;

use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\Grammar\OperatorInfo;
use Chompy\Generator\Grammar\Rule;
use Chompy\Generator\Grammar\TokenInfo;

final class PicoGramParser extends AbstractPicoGramParser
{
    protected function reduceGrammar($items)
    {
        $grammar = new Grammar();
        foreach ($items as $item) {
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
        if ($patternData[0] === '"') {
            $patternData = substr($patternData, 1, -1);
            $patternData = str_replace(['\n', '\r', '\t'], ["\n", "\r", "\t"], $patternData);
            $patternData = stripslashes($patternData);
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
        return [new Rule($output[0], $sequence, $reduceFunction[0])];
    }

    protected function reduceSequenceItems($p1, $p2, $p3)
    {
        $p1[] = $p3[0];
        return $p1;
    }
}
