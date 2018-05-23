<?php

namespace Chompy\Generator\Definition\PicoGram;

use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\Grammar\Rule;
use Chompy\Generator\Grammar\TokenInfo;

final class PicoGramGrammar
{
    const TOKEN_TOKEN = 'TOKEN';
    const TOKEN_REGEX = 'REGEX';
    const TOKEN_OPERATOR = 'OPERATOR';
    const TOKEN_NAME = 'NAME';
    const TOKEN_INTEGER = 'INTEGER';
    const TOKEN_LEFT = 'LEFT';
    const TOKEN_RIGHT = 'RIGHT';
    const TOKEN_NONASSOC = 'NONASSOC';
    const TOKEN_ARROW = 'ARROW';
    const TOKEN_CURLY_OPEN = 'CURLY_OPEN';
    const TOKEN_CURLY_CLOSE = 'CURLY_CLOSE';
    const TOKEN_SPACE = 'SPACE';
    const TOKEN_EOL = 'EOL';
    const TOKEN_ROL = 'ROL';
    const TOKEN_QUOTED = 'QUOTED';

    const ELEM_TOKEN_DEF = 'TokenDef';
    const ELEM_OPERATOR_DEF = 'OperatorDef';
    const ELEM_RULE_DEF = 'RuleDef';
    const ELEM_START = 'Start';
    const ELEM_ITEMS = 'Items';
    const ELEM_ITEM = 'Item';
    const ELEM_ASSOC_DEF = 'AssocDef';
    const ELEM_SEQUENCE = 'Sequence';
    const ELEM_TOKEN_TYPE = 'TokenType';

    /**
     * @return Grammar
     */
    public static function getGrammar()
    {
        $grammar = new Grammar();

        // Tokens.
        $grammar->tokens[self::TOKEN_TOKEN]        = new TokenInfo(TokenInfo::TYPE_STRING, 'token');
        $grammar->tokens[self::TOKEN_REGEX]        = new TokenInfo(TokenInfo::TYPE_STRING, 'regex');
        $grammar->tokens[self::TOKEN_OPERATOR]     = new TokenInfo(TokenInfo::TYPE_STRING, 'operator');
        $grammar->tokens[self::TOKEN_INTEGER]      = new TokenInfo(TokenInfo::TYPE_REGEX, '[0-9]+');
        $grammar->tokens[self::TOKEN_LEFT]         = new TokenInfo(TokenInfo::TYPE_STRING, 'left');
        $grammar->tokens[self::TOKEN_RIGHT]        = new TokenInfo(TokenInfo::TYPE_STRING, 'right');
        $grammar->tokens[self::TOKEN_NONASSOC]     = new TokenInfo(TokenInfo::TYPE_STRING, 'nonassoc');
        $grammar->tokens[self::TOKEN_ARROW]        = new TokenInfo(TokenInfo::TYPE_STRING, '->');
        $grammar->tokens[self::TOKEN_CURLY_OPEN]   = new TokenInfo(TokenInfo::TYPE_STRING, '{');
        $grammar->tokens[self::TOKEN_CURLY_CLOSE]  = new TokenInfo(TokenInfo::TYPE_STRING, '}');
        $grammar->tokens[self::TOKEN_SPACE]        = new TokenInfo(TokenInfo::TYPE_STRING, ' ');
        $grammar->tokens[self::TOKEN_EOL]          = new TokenInfo(TokenInfo::TYPE_STRING, "\n");
        $grammar->tokens[self::TOKEN_ROL]          = new TokenInfo(TokenInfo::TYPE_REGEX, '[^"][^\n]*');
        $grammar->tokens[self::TOKEN_QUOTED]       = new TokenInfo(TokenInfo::TYPE_REGEX, '"[^\n]*?"');
        $grammar->tokens[self::TOKEN_NAME]         = new TokenInfo(TokenInfo::TYPE_REGEX, '[a-zA-Z_][a-zA-Z_0-9]*');

        // Rules.
        $grammar->rules[] = new Rule(self::ELEM_START, [self::ELEM_ITEMS], 'reduceGrammar');
        $grammar->rules[] = new Rule(self::ELEM_ITEMS, [self::ELEM_ITEMS, self::TOKEN_EOL, self::ELEM_ITEM], 'reduceItems');
        $grammar->rules[] = new Rule(self::ELEM_ITEMS, [self::ELEM_ITEMS, self::TOKEN_EOL], 'reduceItems');
        $grammar->rules[] = new Rule(self::ELEM_ITEMS, [self::ELEM_ITEM], 'reduceArrayOf');

        $grammar->rules[] = new Rule(self::ELEM_ITEM, [self::ELEM_TOKEN_DEF], 'reduceIdentity');
        $grammar->rules[] = new Rule(self::ELEM_ITEM, [self::ELEM_OPERATOR_DEF], 'reduceIdentity');
        $grammar->rules[] = new Rule(self::ELEM_ITEM, [self::ELEM_RULE_DEF], 'reduceIdentity');

        $grammar->rules[] = new Rule(self::ELEM_TOKEN_DEF,
            [self::ELEM_TOKEN_TYPE, self::TOKEN_SPACE, self::TOKEN_NAME, self::TOKEN_SPACE, self::TOKEN_ROL],
            'reduceTokenDef');
        $grammar->rules[] = new Rule(self::ELEM_TOKEN_DEF,
            [self::ELEM_TOKEN_TYPE, self::TOKEN_SPACE, self::TOKEN_NAME, self::TOKEN_SPACE, self::TOKEN_QUOTED],
            'reduceTokenDef');
        $grammar->rules[] = new Rule(self::ELEM_TOKEN_TYPE, [self::TOKEN_TOKEN], 'reduceIdentity');
        $grammar->rules[] = new Rule(self::ELEM_TOKEN_TYPE, [self::TOKEN_REGEX], 'reduceIdentity');

        $grammar->rules[] = new Rule(self::ELEM_OPERATOR_DEF,
            [self::TOKEN_OPERATOR, self::TOKEN_SPACE, self::TOKEN_NAME, self::TOKEN_SPACE, self::TOKEN_INTEGER],
            'reduceOperatorDef');$grammar->rules[] = new Rule(self::ELEM_OPERATOR_DEF,
            [self::TOKEN_OPERATOR, self::TOKEN_SPACE, self::TOKEN_NAME, self::TOKEN_SPACE, self::TOKEN_INTEGER, self::TOKEN_SPACE, self::ELEM_ASSOC_DEF],
            'reduceOperatorDef');
        $grammar->rules[] = new Rule(self::ELEM_ASSOC_DEF, [self::TOKEN_LEFT], 'reduceIdentity');
        $grammar->rules[] = new Rule(self::ELEM_ASSOC_DEF, [self::TOKEN_RIGHT], 'reduceIdentity');
        $grammar->rules[] = new Rule(self::ELEM_ASSOC_DEF, [self::TOKEN_NONASSOC], 'reduceIdentity');

        $grammar->rules[] = new Rule(self::ELEM_RULE_DEF,
        [self::TOKEN_NAME, self::TOKEN_SPACE, self::TOKEN_ARROW, self::TOKEN_SPACE, self::ELEM_SEQUENCE, self::TOKEN_SPACE, self::TOKEN_CURLY_OPEN, self::TOKEN_SPACE, self::TOKEN_NAME, self::TOKEN_SPACE, self::TOKEN_CURLY_CLOSE],
            'reduceRuleDef');

        $grammar->rules[] = new Rule(self::ELEM_SEQUENCE, [self::ELEM_SEQUENCE, self::TOKEN_SPACE, self::TOKEN_NAME], 'reduceSequenceItems');
        $grammar->rules[] = new Rule(self::ELEM_SEQUENCE, [self::TOKEN_NAME], 'reduceIdentity');

        return $grammar;
    }
}
