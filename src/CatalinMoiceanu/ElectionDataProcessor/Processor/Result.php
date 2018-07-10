<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Processor;

use CatalinMoiceanu\ElectionDataProcessor\Mapper;
use CatalinMoiceanu\ElectionDataProcessor\Builder\PartFactory;
use CatalinMoiceanu\ElectionDataProcessor\Builder\Part\OverallResult;
use CatalinMoiceanu\ElectionDataProcessor\Builder\Part\ListTypeResult;
use CatalinMoiceanu\ElectionDataProcessor\Builder\Part\GroupResult;

class Result
{
    /** @var Mapper $mapper */
    private $mapper;
    /** @var PartFactory $partFactory */
    private $partFactory;
    /** @var array $gendersUsed */
    private $gendersUsed = ['m', 'f'];

    /**
     * @param Mapper $mapper
     * @param PartFactory $partFactory
     */
    public function __construct(Mapper $mapper, PartFactory $partFactory)
    {
        $this->mapper = $mapper;
        $this->partFactory = $partFactory;
    }

    /**
     * @param array $lines
     * @return OverallResult
     */
    public function getOverallResult(array $lines) : OverallResult
    {
        $registered = 0;
        $votes = 0;
        foreach ($lines as $line) {
            $registered += $this->mapper->getRegisteredVoters($line);
            $votes += $this->mapper->getVotes($line);
        }
        return $this->partFactory->createPrecinctOverallResult($registered, $votes);
    }

    /**
     * @param array $lines
     * @return ListTypeResult
     */
    public function getListTypeResult(array $lines) : ListTypeResult
    {
        $permanent = 0;
        $additional = 0;
        $mobile = 0;
        foreach ($lines as $line) {
            $permanent += $this->mapper->getPermanentListsVotes($line);
            $additional += $this->mapper->getAdditionalListsVotes($line);
            $mobile += $this->mapper->getMobileListsVotes($line);
        }
        return $this->partFactory->createPrecinctListTypeResult($permanent, $additional, $mobile);
    }

    /**
     * @param array $lines
     * @return GroupResult[]
     */
    public function getGroupResult(array $lines) : array
    {
        $groups = [];
        foreach ($this->gendersUsed as $gender) {
            $data = [];
            foreach ($lines as $line) {
                if (empty($data)) {
                    $data = $this->mapper->getAgeGroupsByGender($line, $gender);
                } else {
                    $lineData = $this->mapper->getAgeGroupsByGender($line, $gender);
                    array_walk($data, function(&$value, $key) use ($lineData) {
                        $value += $lineData[$key];
                    });
                }
            }
            $group = $this->partFactory->createPrecinctGroupResult($gender);
            $group->addData($data);
            $groups[] = $group;
        }
        return $groups;
    }
}