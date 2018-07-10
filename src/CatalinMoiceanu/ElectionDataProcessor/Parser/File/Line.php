<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Parser\File;

class Line
{
    /** @var array $columns */
    private $columns;

    /**
     * @param array $columns
     */
    public function __construct(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function getColumn(int $index)
    {
        return $this->columns[$index];
    }
}