<?php

function my_autoload ($class) {
    include(__DIR__ . "/src/" . str_replace('\\', '/', $class) . ".php");
}
spl_autoload_register("my_autoload");

chdir(__DIR__);

use \CatalinMoiceanu\ElectionDataProcessor\Parser;
use \CatalinMoiceanu\ElectionDataProcessor\Builder;
use \CatalinMoiceanu\ElectionDataProcessor\Mapper;
use \CatalinMoiceanu\ElectionDataProcessor\Processor;
use \CatalinMoiceanu\ElectionDataProcessor\Builder\PartFactory;

$parser = new Parser('input/*');
$builder = new Builder();
$mapper = new Mapper();
$partFactory = new PartFactory();
$processor = new Processor($builder, $parser, $mapper, $partFactory);
$processor->process();
foreach ($builder->getParts() as $part) {
    $content = $part->toArray();
    if ($part->getCode() === 'RO') {
        // @TODO: Refactor this
        foreach ($content['u'] as $code => $county) {
            unset($content['u'][$code]['u']);
        }
    }
    $fp = fopen('output/results_' . $part->getCode() . '.json', 'w+');
    fwrite($fp, json_encode($content));
    fclose($fp);
}