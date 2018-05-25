<?php

$dir = __DIR__ . '/..';

require_once $dir . '/vendor/autoload.php';

$parser = new \Chompy\Generator\Definition\PicoGram\PicoGramParser();
$grammar = $parser->parse(file_get_contents($dir . '/res/def-nanogram.txt'));

$generator = \Chompy\Generator\ParserGenerator::defaultGenerator();

$options = $generator->createCodeGeneratorOptions()
    ->setClassName('AbstractNanoGramParser')
    ->setNamespace('Chompy\\Generator\\Definition\\NanoGram');

$generator->write($dir . '/src/Generator/Definition/NanoGram/AbstractNanoGramParser.php', $grammar, $options);

$nanogramParser = new \Chompy\Generator\Definition\NanoGram\NanoGramParser();
$nanogramParser->parse(file_get_contents($dir . '/res/test-nanogram.txt'));
