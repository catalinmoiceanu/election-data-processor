<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Builder\Part;

interface ResultInterface
{
    /**
     * @return array
     */
    public function toArray() : array;
}