<?php

namespace Chompy\Generator;

use Chompy\Generator\Analysis\ItemSet;
use Chompy\Generator\Analysis\Item;
use Chompy\Generator\Grammar\Grammar;
use Chompy\Generator\StateTable\State;
use Chompy\Generator\StateTable\StateTable;

final class LalrAnalyzer implements AnalyzerInterface
{
    public function generateStateTable(Grammar $grammar): StateTable
    {
        $this->validateGrammar($grammar);

        // First build the item sets.
        $itemSets = $this->generateItemSets($grammar);

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
        }

        $firstSets = $this->generateFirstSets($grammar);
        throw new \LogicException('Reduces not implemented yet!');

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
        $firstTokens = [];
        $firstNonterminals = [];
        $nullable = [];

        // Get direct first tokens + nonterminals.
        foreach ($grammar->rules as $rule) {
            if (isset ($rule->input[0])) {
                $firstElement = $rule->input[0];
                if (isset ($grammar->tokens[$firstElement])) {
                    $firstTokens[$rule->output][$firstElement] = $firstElement;
                } else {
                    $firstNonterminals[$rule->output][$firstElement] = $firstElement;
                }
            } else {
                $nullable[$rule->output] = $rule->output;
            }
        }

        // Process elements that may be empty.
        foreach ($grammar->rules as $rule) {
            foreach ($rule->input as $inputElement) {
                if (isset ($grammar->tokens[$inputElement])) {
                    $firstTokens[$rule->output][$inputElement] = $inputElement;
                } else {
                    $firstNonterminals[$rule->output][$inputElement] = $inputElement;
                }
                if (!isset ($nullable[$inputElement])) {
                    break;
                }
            }
        }

        // Close the first sets.
        $changed = true;
        while ($changed) {
            $changed = false;
            foreach ($firstNonterminals as $element => $elementFirstNonterminals) {
                foreach ($elementFirstNonterminals as $firstNonterminal) {
                    $oldFirstTokens = $firstTokens[$element] ?? [];
                    $newFirstTokens = array_unique(
                        array_merge(
                            $oldFirstTokens,
                            $firstTokens[$firstNonterminal] ?? []
                        )
                    );
                    if (count($newFirstTokens) > count($oldFirstTokens)) {
                        $firstTokens[$element] = $newFirstTokens;
                        $changed = true;
                    }
                }
            }
        }

        return $firstTokens;
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
        if (isset($grammar->tokens['$'])) {
            throw new \Exception('Invalid token name: $');
        }
        foreach ($grammar->rules as $rule) {
            if (isset ($grammar->tokens[$rule->output])) {
                throw new \Exception('Nonterminal name conflicts with token name: ' . $rule->output);
            }
        }
    }
}
