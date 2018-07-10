<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Builder;

class PartPool implements \Countable
{
    /** @var Part[] $parts */
    private $parts;

    /**
     * @param $partCode
     * @return bool
     */
    public function exists($partCode) : bool
    {
        return isset($this->parts[$partCode]);
    }

    /**
     * @param $partCode
     * @return Part
     */
    public function get($partCode) : Part
    {
        if (! $this->exists($partCode)) {
            throw new \InvalidArgumentException('Invalid part code.');
        }

        return $this->parts[$partCode];
    }

    /**
     * @param Part $part
     * @return $this
     */
    public function add(Part $part)
    {
        if ($this->exists($part->getCode())) {
            throw new \InvalidArgumentException('Part already exists in pool.');
        }

        $this->parts[$part->getCode()] = $part;
        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->parts);
    }
}