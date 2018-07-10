<?php

namespace CatalinMoiceanu\ElectionDataProcessor;

class Parser
{
    /** @var string $path */
    private $path;
    /** @var Parser\File[] $files */
    private $files = [];

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->files = $this->fetchFiles();
    }

    private function fetchFiles()
    {
        return array_map(function($filePath) {
            return (new Parser\File($filePath))->parse();
        }, glob($this->path));
    }

    /**
     * @return Parser\File[]
     */
    public function getFiles()
    {
        return $this->files;
    }
}