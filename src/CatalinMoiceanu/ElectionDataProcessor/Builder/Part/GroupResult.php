<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Builder\Part;

class GroupResult implements ResultInterface
{
    /** @var string $gender */
    private $gender;
    /** @var array $data */
    private $data;

    /**
     * @param string $gender
     */
    public function __construct(string $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @param array $data
     */
    public function addData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            $this->gender => $this->data
        ];
    }
}