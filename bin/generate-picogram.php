<?php

$dir = __DIR__ . '/..';

require_once $dir . '/vendor/autoload.php';

$parser = new \Chompy\Generator\Definition\PicoGram\PicoGramParser();
$grammar = $parser->parse(file_get_contents($dir . '/res/def-picogram.txt'));

$generator = \Chompy\Generator\ParserGenerator::defaultGenerator();

$options = $generator->createCodeGeneratorOptions()
    ->setClassName('AbstractPicoGramParser')
    ->setNamespace('Chompy\\Generator\\Definition\\PicoGram');

$generator->write($dir . '/src/Generator/Definition/PicoGram/AbstractPicoGramParser.php', $grammar, $options);
