<?php

namespace CatalinMoiceanu\ElectionDataProcessor;

use CatalinMoiceanu\ElectionDataProcessor\Builder\Part;
use CatalinMoiceanu\ElectionDataProcessor\Builder\PartPool;
use CatalinMoiceanu\ElectionDataProcessor\Builder\PartFactory;
use CatalinMoiceanu\ElectionDataProcessor\Processor\Result;

class Processor
{
    /** @var Builder $builder */
    private $builder;
    /** @var Parser $parser */
    private $parser;
    /** @var Mapper $mapper */
    private $mapper;
    /** @var PartFactory $partFactory */
    private $partFactory;
    /** @var PartPool[] $partPools */
    private $partPools;

    /**
     * @param Builder $builder
     * @param Parser $parser
     * @param Mapper $mapper
     * @param PartFactory $partFactory
     */
    public function __construct(Builder $builder, Parser $parser, Mapper $mapper, PartFactory $partFactory)
    {
        $this->builder = $builder;
        $this->parser = $parser;
        $this->mapper = $mapper;
        $this->partFactory = $partFactory;
        $this->partPools = [
            'county' => new PartPool(),
            'district' => new PartPool(),
            'locality' => new PartPool()
        ];
    }

    public function process()
    {
        $country = $this->partFactory->createPart('RO', 'General');
        $this->builder->addPart($country);
        foreach ($this->parser->getFiles() as $file) {
            $county = $this->partFactory->createPart(
                $this->mapper->getCountyCode($file->getFirstLine()),
                $this->mapper->getCountyName($file->getFirstLine())
            );
            $country->addPart($county);
            foreach ($file->getLines() as $line) {
                $district = $this->getPart(
                    'district',
                    $this->mapper->getDistrictCode($line),
                    $this->mapper->getDistrictName($line)
                );
                $locality = $this->getPart(
                    'locality',
                    $this->mapper->getLocalityCode($line),
                    $this->mapper->getLocalityName($line)
                );
                $precinct = $this->partFactory->createPart(
                    $this->mapper->getPrecinctCode($line),
                    $this->mapper->getPrecinctName($line)
                );
                $this->setLineResult($precinct, $line);
                $locality->addPart($precinct);
                $district->addPart($locality);
                $county->addPart($district);
            }
            $this->builder->addPart($county);
        }
    }

    /**
     * @param string $type
     * @param string $code
     * @param string $name
     * @return Part
     */
    private function getPart(string $type, string $code, string $name)
    {
        if ($this->partPools[$type]->exists($code)) {
            return $this->partPools[$type]->get($code);
        }

        $part = $this->partFactory->createPart($code, $name);
        $this->partPools[$type]->add($part);

        return $part;
    }

    /**
     * @param Part $part
     * @param $line
     */
    private function setLineResult(Part $part, $line)
    {
        $result = new Result($this->mapper, $this->partFactory);
        $part->addResult($result->getOverallResult([ $line ]));
        $part->addResult($result->getListTypeResult([ $line ]));
        foreach ($result->getGroupResult([ $line ]) as $group) {
            $part->addResult($group);
        }
    }
}