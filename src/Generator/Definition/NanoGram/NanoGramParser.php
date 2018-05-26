<?php

namespace Charm\Generator\Definition\NanoGram;

use Charm\Generator\Grammar\Grammar;
use Charm\Generator\Grammar\OperatorInfo;
use Charm\Generator\Grammar\Reduce\CallReduceAction;
use Charm\Generator\Grammar\Reduce\CopyReduceAction;
use Charm\Generator\Grammar\Rule;
use Charm\Generator\Grammar\TokenInfo;
use Charm\Generator\Grammar\WhitespaceInfo;

final class NanoGramParser extends AbstractNanoGramParser
{
    const ITEM_RULESET = 'ruleset';
    const ITEM_INCLUDE = 'include';
    const ITEM_TOKEN = 'token';
    const ITEM_WHITESPACE = 'whitespace';
    const ITEM_OPERATOR = 'operator';

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
            switch ($item[0]) {
                case self::ITEM_TOKEN:
                    $grammar->tokens[$item[2]] = $item[1];
                    break;
                case self::ITEM_OPERATOR:
                    $grammar->operators[$item[2]] = $item[1];
                    break;
                case self::ITEM_RULESET:
                    foreach ($item[1] as $rule) {
                        $grammar->rules[] = $rule;
                    }
                    break;
                case self::ITEM_INCLUDE:
                    $grammar->tokens = array_merge($grammar->tokens, $item[1]->tokens);
                    $grammar->operators = array_merge($grammar->operators, $item[1]->operators);
                    $grammar->rules = array_merge($grammar->rules, $item[1]->rules);
                    if ($item[1]->whitespace !== null) {
                        $grammar->whitespace = $item[1]->whitespace;
                    }
                    break;
                case self::ITEM_WHITESPACE:
                    $grammar->whitespace = $item[1];
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
        $tokenType = null;
        switch ($type[0]) {
            case 'chars':
                $tokenType = TokenInfo::TYPE_CHARS;
                break;
            case 'regex':
                $tokenType = TokenInfo::TYPE_REGEX;
                break;
            case 'token':
            default:
                $tokenType = TokenInfo::TYPE_STRING;
                break;
        }
        return [self::ITEM_TOKEN, new TokenInfo($tokenType, $pattern[0], false), $name[0]];
    }

    protected function reduceEscapedToken($p0, $p1, $token)
    {
        $token[1]->pattern = str_replace(['\n', '\r', '\t', '\s'], ["\n", "\r", "\t", ' '], $token[1]->pattern);
        return $token;
    }

    protected function reduceExactToken($p0, $p1, $token)
    {
        $token[1]->exact = true;
        return $token;
    }

    protected function reduceWhitespaceDef($p0, $p1, $tokenName, $p3 = NULL, $nostart = NULL)
    {
        return [self::ITEM_WHITESPACE, new WhitespaceInfo($tokenName[0], $nostart === null)];
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
        return [self::ITEM_OPERATOR, new OperatorInfo((int)$precedence[0], $assocType), $name[0]];
    }

    protected function reduceRuleSet($name, $p1, $p2, $p3, $rhsList)
    {
        $rules = [];
        foreach ($rhsList as $rhs) {
            $rules[] = new Rule($name[0], $rhs[0], $rhs[1]);
        }
        return [self::ITEM_RULESET, $rules];
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
        return [self::ITEM_INCLUDE, $grammar];
    }

}
