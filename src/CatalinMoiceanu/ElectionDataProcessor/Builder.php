<?php

namespace CatalinMoiceanu\ElectionDataProcessor;

use \CatalinMoiceanu\ElectionDataProcessor\Builder\Part;

class Builder
{
    /**
     * @var Part[]
     */
    private $parts = [];

    /**
     * @param Part $part
     */
    public function addPart(Part $part)
    {
        $this->parts[] = $part;
    }

    /**
     * @return Part[]
     */
    public function getParts()
    {
        return $this->parts;
    }
}