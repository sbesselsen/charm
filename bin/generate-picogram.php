<?php

$dir = __DIR__ . '/..';

require_once $dir . '/vendor/autoload.php';

$parser = new \Charm\Generator\Definition\PicoGram\PicoGramParser();
$grammar = $parser->parse(file_get_contents($dir . '/res/def-picogram.txt'));

$generator = \Charm\Generator\ParserGenerator::defaultGenerator();

$options = $generator->createCodeGeneratorOptions()
    ->setClassName('AbstractPicoGramParser')
    ->setNamespace('Charm\\Generator\\Definition\\PicoGram');

$generator->write($dir . '/src/Generator/Definition/PicoGram/AbstractPicoGramParser.php', $grammar, $options);
