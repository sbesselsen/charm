<?php

namespace Charm\Generator\Definition\NanoGram;

use Charm\Generator\Grammar\Grammar;
use Charm\Generator\Grammar\OperatorInfo;
use Charm\Generator\Grammar\Reduce\CallReduceAction;
use Charm\Generator\Grammar\Reduce\CopyReduceAction;
use Charm\Generator\Grammar\Rule;
use Charm\Generator\Grammar\TokenInfo;

final class NanoGramParser extends AbstractNanoGramParser
{
    const INTERMEDIATE_RULESET = 'ruleset';

    private $currentPath = NULL;

    /**
     * Parse a file.
     *
     * @param string $path
     *
     * @return Grammar
     * @throws \Exception
     */
    public function parseFile(string $path): Grammar
    {
        if (!file_exists($path)) {
            throw new \Exception('File not found: ' . $path);
        }
        return $this->parseWithCurrentPath(file_get_contents($path), $path);
    }

    /**
     * @param string $string
     *
     * @return Grammar
     * @throws \Exception
     */
    public function parse(string $string): Grammar
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection, PhpVoidFunctionResultUsedInspection */
        return parent::parse($string);
    }

    /**
     * Parse a grammar with the current path set.
     *
     * The current path is used to resolve the path to included files.
     *
     * @param string $string
     * @param string $path
     *
     * @return Grammar
     * @throws \Exception
     */
    public function parseWithCurrentPath(string $string, string $path): Grammar
    {
        $prevPath = $this->currentPath;
        $this->currentPath = $path;
        try {
            $result = $this->parse($string);
            $this->currentPath = $prevPath;
            return $result;
        } catch (\Exception $e) {
            $this->currentPath = $prevPath;
            throw new \Exception($e->getMessage() . ' in ' . $path, $e->getCode());
        }
    }

    /**
     * @param $items
     *
     * @return Grammar
     * @throws \Exception
     */
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
            } elseif ($def instanceof Grammar) {
                // Included grammar; merge it!
                $grammar->tokens = array_merge($grammar->tokens, $def->tokens);
                $grammar->operators = array_merge($grammar->operators, $def->operators);
                $grammar->rules = array_merge($grammar->rules, $def->rules);
            } elseif ($def === self::INTERMEDIATE_RULESET) {
                foreach ($item[1] as $rule) {
                    $grammar->rules[] = $rule;
                }
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
        return [new TokenInfo($type[0] === 'token' ? TokenInfo::TYPE_STRING : TokenInfo::TYPE_REGEX, $pattern[0]), $name[0]];
    }

    protected function reduceEscapedTokenDef($p0, $p1, $tokenData)
    {
        /** @var TokenInfo $token */
        $token = $tokenData[0];
        if (isset ($tokenData[2])) {
            throw new \Exception('Duplicate escape flag for token ' . $tokenData[1]);
        }
        if ($token->type === TokenInfo::TYPE_REGEX) {
            throw new \Exception('Escaped tokens cannot be regex (regex is self-escaping)');
        }
        $token->pattern = str_replace(['\n', '\r', '\t', '\s'], ["\n", "\r", "\t", ' '], $token->pattern);
        $tokenData[] = 'escaped';
        return $tokenData;
    }

    protected function reduceWhitespaceTokenDef($p0, $p1, $tokenData)
    {
        /** @var TokenInfo $token */
        $token = $tokenData[0];
        if ($token->isWhitespace) {
            throw new \Exception('Duplicate whitespace flag for token ' . $tokenData[1]);
        }
        $token->isWhitespace = true;
        return $tokenData;
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

    /*
    protected function reduceRuleDef($output, $p2, $p3, $p4, $sequence, $p6 = null, $p7 = null, $p8 = null, $reduceAction = null, $p10 = null, $p11 = null)
    {
        if ($reduceAction === null) {
            $reduceAction = new CopyReduceAction(0);
        }
        return [new Rule($output[0], $sequence, $reduceAction)];
    }
    */
    protected function reduceRuleSet($name, $p1, $p2, $p3, $rhsList)
    {
        $rules = [];
        foreach ($rhsList as $rhs) {
            $rules[] = new Rule($name[0], $rhs[0], $rhs[1]);
        }
        return [self::INTERMEDIATE_RULESET, $rules];
    }

    protected function reduceRuleRhsList($list, $p1, $p2, $rhs)
    {
        $list[] = $rhs;
        return $list;
    }

    protected function reduceRuleRhs($sequence, $p1 = null, $p2 = null, $p3 = null, $reduceAction = null, $p5 = null, $p6 = null)
    {
        if ($reduceAction === null) {
            $reduceAction = new CopyReduceAction(0);
        }
        return [$sequence, $reduceAction];
    }


    protected function reduceSequenceItems($p1, $p2, $p3)
    {
        $p1[] = $p3[0];
        return $p1;
    }

    protected function reduceCallReduceAction($name, $p2 = null, $args = null, $p4 = null)
    {
        return new CallReduceAction($name[0], $args);
    }

    protected function reduceCopyReduceAction($p0)
    {
        return new CopyReduceAction((int)$p0);
    }

    protected function reduceReduceActionArgs($args, $p2, $p3, $arg)
    {
        $args[] = $arg;
        return $args;
    }

    protected function reduceReduceActionPointer($p1)
    {
        return $p1[1];
    }

    /**
     * @param $p0
     * @param $p1
     * @param $path
     *
     * @return array
     *
     * @throws \Exception
     *   If the current path is not set.
     */
    protected function reduceInclude($p0, $p1, $path)
    {
        if ($this->currentPath === null) {
            throw new \Exception('Cannot load includes if current path is not set');
        }
        $fullPath = dirname($this->currentPath) . DIRECTORY_SEPARATOR . $path[0];
        $grammar = $this->parseFile($fullPath);
        return [$grammar];
    }

}
