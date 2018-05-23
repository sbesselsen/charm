<?php

$dir = __DIR__ . '/..';

require_once $dir . '/vendor/autoload.php';

$grammar = \Chompy\Generator\Definition\PicoGram\PicoGramGrammar::getGrammar();

$generator = \Chompy\Generator\ParserGenerator::defaultGenerator();

$options = $generator->createCodeGeneratorOptions()
    ->setClassName('AbstractPicoGramParser')
    ->setNamespace('Chompy\\Generator\\Definition\\PicoGram');

$generator->write($dir . '/src/Generator/Definition/PicoGram/AbstractPicoGramParser.php', $grammar, $options);

// Make sure it worked!
include ($dir . '/src/Generator/Definition/PicoGram/PicoGramParser.php');
$parser = new \Chompy\Generator\Definition\PicoGram\PicoGramParser();
