<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Parser;

class File
{
    /** @var string $filePath */
    private $filePath;
    /** @var File\Code $code */
    private $code;
    /** @var File\Line $header */
    private $header;
    /** @var File\Line[] $lines */
    private $lines = [];

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->code = new File\Code($filePath);
    }

    /**
     * @return File\Code
     */
    public function getCode() : File\Code
    {
        return $this->code;
    }

    /**
     * @return File\Line
     */
    public function getHeader() : File\Line
    {
        return $this->header;
    }

    /**
     * @return File\Line[]
     */
    public function getLines() : array
    {
        return $this->lines;
    }

    /**
     * @return File\Line
     */
    public function getFirstLine() : File\Line
    {
        return reset($this->lines);
    }

    /**
     * @return $this
     */
    public function parse() : self
    {
        if (($handle = fopen($this->filePath, "r")) === false) {
            return $this;
        }

        while (($line = fgetcsv($handle)) !== false) {
            if (! $this->header) {
                $this->header = new File\Line($line);
                continue;
            }
            $this->lines[] = new File\Line($line);
        }

        return $this;
    }
}