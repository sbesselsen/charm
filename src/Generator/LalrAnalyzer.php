<?php

namespace Charm\Generator;

use Charm\Generator\Analysis\ItemSet;
use Charm\Generator\Analysis\Item;
use Charm\Generator\Grammar\Grammar;
use Charm\Generator\Grammar\OperatorInfo;
use Charm\Generator\Grammar\Rule;
use Charm\Generator\StateTable\State;
use Charm\Generator\StateTable\StateTable;

final class LalrAnalyzer implements AnalyzerInterface
{
    const END_VIRTUAL_TOKEN = '$';
    const START_ELEMENT = 'Start';

    const RESOLUTION_SHIFT = 'shift';
    const RESOLUTION_REDUCE = 'reduce';
    const RESOLUTION_NEITHER = 'neither';

    public function generateStateTable(Grammar $grammar): StateTable
    {
        $this->validateGrammar($grammar);

        // First generate the item sets.
        $itemSets = $this->generateItemSets($grammar);

        // Then the first sets.
        $firstSets = $this->generateFirstSets($grammar);

        // And the follow sets.
        $followSets = $this->generateFollowSets($grammar, $firstSets);

        // Then generate the state table.
        $stateTable = new StateTable();
        foreach ($itemSets as $itemSetIndex => $itemSet) {
            $state = new State();
            $stateTable->states[$itemSetIndex] = $state;

            foreach ($itemSet->transitions as $element => $targetStateIndex) {
                if (isset ($grammar->tokens[$element])) {
                    // This is a token; shift!
                    $state->shifts[$element] = $targetStateIndex;
                } else {
                    // This is an element; add it to the goto table.
                    $state->gotos[$element] = $targetStateIndex;
                }
            }

            foreach ($itemSet->items as $item) {
                $rule = $grammar->rules[$item->ruleIndex];
                if ($item->position !== count($rule->input)) {
                    // No reduce possible: rule is not at end.
                    continue;
                }

                foreach ($followSets[$rule->output] as $followElement) {
                    if (isset ($state->shifts[$followElement])) {
                        // Shift/reduce conflict; try to resolve!
                        switch ($this->resolveShiftReduceConflict($grammar, $followElement, $item->ruleIndex)) {
                            case self::RESOLUTION_REDUCE:
                                $state->reduces[$followElement] = $item->ruleIndex;
                                unset ($state->shifts[$followElement]);
                                break;
                            case self::RESOLUTION_SHIFT:
                                break;
                            case self::RESOLUTION_NEITHER:
                                unset ($state->shifts[$followElement]);
                                break;
                        }
                    } else {
                        $state->reduces[$followElement] = $item->ruleIndex;
                    }
                }
            }
        }

        return $stateTable;
    }

    /**
     * @param Grammar $grammar
     *
     * @return ItemSet[]
     */
    private function generateItemSets(Grammar $grammar): array
    {
        /** @var ItemSet[] $itemSets */
        $itemSets = [];

        $itemSetIndex = [];

        if ($grammar->rules) {
            // Generate the first item set I0.
            $itemSet0 = new ItemSet();
            $item0 = new Item();
            $item0->ruleIndex = 0;
            $item0->position = 0;
            $itemSet0->items[] = $item0;
            $this->closeItemSet($itemSet0, $grammar);
            $itemSetIndex[$this->itemSetKey($itemSet0)] = 0;
            $itemSets[] = $itemSet0;
        }

        // Walk down through all the item sets to see if they need expansion.
        for ($i = 0; $i < count($itemSets); $i++) {
            foreach ($this->itemSetExpansions($itemSets[$i], $grammar) as $element => $itemSetExpansion) {
                $expansionKey = $this->itemSetKey($itemSetExpansion);
                if (!isset ($itemSetIndex[$expansionKey])) {
                    $this->closeItemSet($itemSetExpansion, $grammar);
                    $itemSetIndex[$expansionKey] = count($itemSets);
                    $itemSets[] = $itemSetExpansion;
                }
                $itemSets[$i]->transitions[$element] = $itemSetIndex[$expansionKey];
            }
        }

        return $itemSets;
    }

    /**
     * @param ItemSet $itemSet
     * @param Grammar $grammar
     *
     * @return ItemSet[]
     */
    private function itemSetExpansions(ItemSet $itemSet, Grammar $grammar): array {
        $expansions = [];
        foreach (array_merge($itemSet->items, $itemSet->closureItems) as $item) {
            /** @var Item $item */
            $rule = $grammar->rules[$item->ruleIndex];
            if ($item->position === count($rule->input)) {
                // This item is already at the end of its rule.
                continue;
            }
            $nextElement = $rule->input[$item->position];
            if (isset ($expansions[$nextElement])) {
                $expansionItemSet = $expansions[$nextElement];
            } else {
                $expansionItemSet = new ItemSet();
                $expansions[$nextElement] = $expansionItemSet;
            }
            $expansionItem = new Item();
            $expansionItem->ruleIndex = $item->ruleIndex;
            $expansionItem->position = $item->position + 1;
            $expansionItemSet->items[] = $expansionItem;
        }

        return $expansions;
    }

    /**
     * @param ItemSet $itemSet
     * @param Grammar $grammar
     */
    private function closeItemSet(ItemSet $itemSet, Grammar $grammar) {
        $prevCount = -1;

        $existingItemsSet = [];
        foreach ($itemSet->items as $i => $item) {
            $existingItemsSet[$this->itemKey($item)] = true;
        }

        while (count($itemSet->closureItems) > $prevCount) {
            $prevCount = count($itemSet->closureItems);

            /** @var Item[] $allItems */
            $allItems = array_merge($itemSet->items, $itemSet->closureItems);
            foreach ($allItems as $item) {
                $rule = $grammar->rules[$item->ruleIndex];
                if ($item->position === count($rule->input)) {
                    // This item is already at the end of its rule.
                    continue;
                }
                $nextElement = $rule->input[$item->position];
                foreach ($grammar->rules as $closureRuleIndex => $closureRule) {
                    if ($closureRule->output !== $nextElement) {
                        continue;
                    }
                    $closureItem = new Item();
                    $closureItem->ruleIndex = $closureRuleIndex;
                    $closureItem->position = 0;
                    $closureItemKey = $this->itemKey($closureItem);
                    if (!isset ($existingItemsSet[$closureItemKey])) {
                        $itemSet->closureItems[] = $closureItem;
                        $existingItemsSet[$closureItemKey] = true;
                    }
                }
            }
        }
    }

    /**
     * @param Grammar $grammar
     *
     * @return array
     *   [string nonterminal => array firsts]
     */
    private function generateFirstSets(Grammar $grammar): array
    {
        $firstSets = [];
        foreach (array_keys($grammar->tokens) as $token) {
            $firstSets[$token] = [$token => $token];
        }

        $changed = true;
        while ($changed) {
            $changed = false;
            foreach ($grammar->rules as $rule) {
                $firstItem = $rule->input[0];
                if (!isset ($firstSets[$firstItem])) {
                    continue;
                }
                $oldFirstSet = $firstSets[$rule->output] ?? [];
                $newFirstSet = array_merge($oldFirstSet, $firstSets[$firstItem]);
                if (array_diff_key($newFirstSet, $oldFirstSet)) {
                    $changed = true;
                    $firstSets[$rule->output] = $newFirstSet;
                }
            }
        }

        return $firstSets;
    }

    /**
     * @param Grammar $grammar
     * @param array $firstSets
     *
     * @return array
     *   [string nonterminal => [string followTokens]]
     */
    private function generateFollowSets(Grammar $grammar, array $firstSets) {
        $followSets = [];
        foreach ($grammar->rules as $rule) {
            $followSets[$rule->output] = [];
        }
        $followSets[self::START_ELEMENT] = [self::END_VIRTUAL_TOKEN => self::END_VIRTUAL_TOKEN];

        $changed = true;
        while ($changed) {
            $changed = false;
            foreach ($grammar->rules as $rule) {
                $last = count($rule->input) - 1;
                foreach ($rule->input as $i => $element) {
                    if (isset ($grammar->tokens[$element])) {
                        continue;
                    }
                    $oldFollowSet = $followSets[$element];
                    if ($i === $last) {
                        $newFollowSet = $followSets[$rule->output];
                    } else {
                        $newFollowSet = $firstSets[$rule->input[$i + 1]];
                    }
                    if (array_diff_key($newFollowSet, $oldFollowSet)) {
                        $changed = true;
                        $followSets[$element] = array_merge($oldFollowSet, $newFollowSet);
                    }
                }
            }
        }

        return $followSets;
    }

    /**
     * @param ItemSet $itemSet
     *
     * @return string
     */
    private function itemSetKey(ItemSet $itemSet): string {
        $parts = array_map([$this, 'itemKey'], $itemSet->items);
        natsort($parts);
        return implode(',', $parts);
    }

    /**
     * @param Item $item
     *
     * @return string
     */
    private function itemKey(Item $item): string {
        return $item->ruleIndex . ':' . $item->position;
    }

    /**
     * @param Grammar $grammar
     * @throws \Exception
     *   If the grammar is invalid.
     */
    private function validateGrammar(Grammar $grammar)
    {
        if (isset($grammar->tokens[self::END_VIRTUAL_TOKEN])) {
            throw new \Exception('Invalid token name: $');
        }
        $startRuleIndex = null;
        foreach ($grammar->rules as $ruleIndex => $rule) {
            if ($rule->output === self::START_ELEMENT) {
                if ($startRuleIndex !== null) {
                    throw new \Exception('Cannot have two rules named ' . self::START_ELEMENT);
                }
                $startRuleIndex = $ruleIndex;
            }
            if (isset ($grammar->tokens[$rule->output])) {
                throw new \Exception('Nonterminal name conflicts with token name: ' . $rule->output);
            }
        }
        if ($startRuleIndex === null) {
            throw new \Exception('Must have exactly one rule named ' . self::START_ELEMENT);
        }
        if ($startRuleIndex !== 0) {
            $startRules = array_splice($grammar->rules, $startRuleIndex, 1);
            $grammar->rules = array_merge($startRules, $grammar->rules);
        }

        // Make sure all operators on each precedence level have the same associativity.
        $operatorsByPrecedence = [];
        foreach ($grammar->operators as $operator => $operatorInfo) {
            if (!isset ($operatorsByPrecedence[$operatorInfo->precedence])) {
                $operatorsByPrecedence[$operatorInfo->precedence] = [];
            }
            $operatorsByPrecedence[$operatorInfo->precedence][$operator] = $operatorInfo;
        }
        $associativity = NULL;
        $associativityOperator = NULL;
        foreach ($operatorsByPrecedence as $operators) {
            foreach ($operators as $operator => $operatorInfo) {
                /** @var OperatorInfo $operatorInfo */
                if ($associativity === null) {
                    $associativity = $operatorInfo->associativity;
                    $associativityOperator = $operator;
                } elseif ($associativity !== $operatorInfo->associativity) {
                    throw new \Exception('Operators ' . $associativityOperator . ' and ' . $operator
                        . ' have the same precedence, but different associativity');
                }
            }
        }

        $knownElements = [];
        foreach ($grammar->rules as $rule) {
            $knownElements[$rule->output] = $rule->output;
        }
        foreach ($grammar->rules as $rule) {
            foreach ($rule->input as $element) {
                if (!isset($grammar->tokens[$element]) && !isset($knownElements[$element])) {
                    throw new \Exception('Unknown element ' . $element . ' referenced in rule ' . $this->dumpRule($rule));
                }
            }
        }
    }

    /**
     * @param Grammar $grammar
     * @param ItemSet[] $itemSets
     * @return string
     */
    private function dumpItemSets(Grammar $grammar, array $itemSets)
    {
        $lines = [];
        foreach ($itemSets as $i => $itemSet) {
            $lines[] = "I{$i}:";
            foreach ($itemSet->items as $item) {
                $rule = $grammar->rules[$item->ruleIndex];
                $lines[] = "  " . $this->dumpRule($rule, $item->position);
            }
            foreach ($itemSet->closureItems as $item) {
                $rule = $grammar->rules[$item->ruleIndex];
                $lines[] = "  + " . $this->dumpRule($rule, $item->position);
            }
            foreach ($itemSet->transitions as $element => $targetItemSet) {
                $lines[] = '  ' . $element . ' > ' . $targetItemSet;
            }
            $lines[] = '';
        }
        return implode("\n", $lines);
    }

    /**
     * @param Rule $rule
     * @param int|null $position
     * @return string
     */
    private function dumpRule(Rule $rule, int $position = null) {
        $input = $rule->input;
        if ($position !== null) {
            array_splice($input, $position, 0, ['@']);
        }
        return "{$rule->output} -> " . implode(' ', $input);
    }

    /**
     * @param Grammar $grammar
     * @param array $firstSets
     * @return string
     */
    private function dumpFirstSets(Grammar $grammar, array $firstSets)
    {
        $lines = [];
        foreach ($firstSets as $element => $firsts) {
            if (isset ($grammar->tokens[$element])) {
                continue;
            }
            $lines[] = "{$element}:";
            foreach ($firsts as $first) {
                $lines[] = "  - {$first}";
            }
            $lines[] = '';
        }
        return implode("\n", $lines);
    }

    /**
     * @param Grammar $grammar
     * @param array $followSets
     * @return string
     */
    private function dumpFollowSets(Grammar $grammar, array $followSets)
    {
        return $this->dumpFirstSets($grammar, $followSets);
    }

    /**
     * @param Grammar $grammar
     * @param string $shiftElement
     * @param int $reduceRuleIndex
     *
     * @return string
     *   One of self::RESOLUTION_*.
     *
     * @throws \Exception
     */
    private function resolveShiftReduceConflict(Grammar $grammar, string $shiftElement, int $reduceRuleIndex)
    {
        // Find the operator in the reduce rule.
        $reduceRule = $grammar->rules[$reduceRuleIndex];
        $lastReduceOperator = null;
        foreach (array_reverse($reduceRule->input) as $element) {
            if (isset ($grammar->operators[$element])) {
                $lastReduceOperator = $element;
            }
        }

        if ($lastReduceOperator === null || !isset ($grammar->operators[$shiftElement])) {
            throw new \Exception('Shift/reduce conflict when encountering token '
                . $shiftElement . ' after rule ' . $this->dumpRule($reduceRule));
        }

        $reduceOperatorInfo = $grammar->operators[$lastReduceOperator];
        $shiftOperatorInfo = $grammar->operators[$shiftElement];

        if ($reduceOperatorInfo->precedence > $shiftOperatorInfo->precedence) {
            // Reduce!
            return self::RESOLUTION_REDUCE;
        }
        if ($reduceOperatorInfo->precedence < $shiftOperatorInfo->precedence) {
            // Reduce!
            return self::RESOLUTION_SHIFT;
        }

        // We can now check associativity only on the reduce operator, because if both operators have the same
        // precedence, then they must have the same associativity (this is checked in validateGrammar()).
        if ($reduceOperatorInfo->associativity === OperatorInfo::ASSOC_LEFT) {
            // Left associative: reduce.
            return self::RESOLUTION_REDUCE;
        }
        if ($reduceOperatorInfo->associativity === OperatorInfo::ASSOC_RIGHT) {
            // Right associative: shift.
            return self::RESOLUTION_SHIFT;
        }

        return self::RESOLUTION_NEITHER;
    }
}
