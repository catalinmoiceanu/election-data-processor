<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Parser\File;

class Code
{
    const FILE_PATTERN = '/_(.*)\./m';

    /** @var string $filePath */
    private $filePath;
    /** @var string $value */
    private $value;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->value = $this->fetchValue();
    }

    /**
     * @return string
     */
    private function fetchValue() : string
    {
        $fileInfo = [];
        preg_match(self::FILE_PATTERN, $this->filePath, $fileInfo);
        return $fileInfo[1];
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}