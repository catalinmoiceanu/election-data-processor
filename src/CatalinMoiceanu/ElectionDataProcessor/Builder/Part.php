<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Builder;

class Part
{
    /** @var string $code */
    private $code;
    /** @var string $name */
    private $name;
    /** @var array $parts */
    private $parts = [];
    /** @var array $results */
    private $results = [];

    /**
     * @param $code
     * @param $name
     */
    public function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param Part $part
     */
    public function addPart(Part $part)
    {
        if (! isset($this->parts[$part->getCode()])) {
            $this->parts[$part->getCode()] = $part;
        }
    }

    /**
     * @return Part[]
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * @param Part\ResultInterface $result
     */
    public function addResult(Part\ResultInterface $result)
    {
        $this->results[] = $result;
    }

    /**
     * @return bool
     */
    public function hasResults()
    {
        return ! empty($this->results);
    }

    /**
     * @return Part\ResultInterface[] $result
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param $results
     * @return array
     */
    private function getReducedResults($results)
    {
        return array_reduce(array_map(function(Part\ResultInterface $result) {
            return $result->toArray();
        }, $results), 'array_merge', []);
    }

    /**
     * @return array
     */
    public function getTotalResults()
    {
        $results = [];
        $this->calculateTotalResults($results, $this);
        $results['p'] = $results['r'] ? round($results['t'] / $results['r'] * 100, 2) : null;
        return $results;
    }

    /**
     * @TODO: Refactor results methods
     *
     * @param array $results
     * @param Part $part
     */
    private function calculateTotalResults(array &$results, Part $part)
    {
        if ($part->hasResults()) {
            $partResults = $this->getReducedResults($part->getResults());
            if (empty($results)) {
                $results = $partResults;
            } else {
                foreach ($results as $key => $value) {
                    if (is_array($value)) {
                        foreach ($partResults[$key] as $k => $v) {
                            $results[$key][$k] += $v;
                        }
                    } else {
                        $results[$key] += $partResults[$key];
                    }
                }
            }
        }
        else {
            foreach ($part->getParts() as $childPart) {
                $this->calculateTotalResults($results, $childPart);
            }
        }
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'c' => $this->code,
            'n' => $this->name,
            'u' => array_map(function(Part $part) {
                return $part->toArray();
            }, $this->parts),
            'res' => $this->hasResults() ? $this->getReducedResults($this->results) : $this->getTotalResults()
        ];
    }
}