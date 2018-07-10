<?php

namespace CatalinMoiceanu\ElectionDataProcessor;

class Mapper
{
    /**
     * @param Parser\File\Line $line
     * @param string $column
     * @return mixed
     */
    public function get(Parser\File\Line $line, string $column) : string
    {
        return $line->getColumn($column);
    }

    /**
     * @param Parser\File\Line $line
     * @return mixed
     */
    public function getCountyCode(Parser\File\Line $line) : string
    {
        return $this->get($line, 1);
    }

    /**
     * @param Parser\File\Line $line
     * @return mixed
     */
    public function getCountyName(Parser\File\Line $line) : string
    {
        return $this->get($line, 2);
    }

    /**
     * @param Parser\File\Line $line
     * @return string
     */
    public function getDistrictCode(Parser\File\Line $line) : string
    {
        return $this->get($line, 3);
    }

    /**
     * @param Parser\File\Line $line
     * @return string
     */
    public function getDistrictName(Parser\File\Line $line) : string
    {
        return $this->get($line, 4);
    }

    /**
     * @param Parser\File\Line $line
     * @return string
     */
    public function getLocalityCode(Parser\File\Line $line) : string
    {
        return $this->get($line, 5);
    }

    /**
     * @param Parser\File\Line $line
     * @return string
     */
    public function getLocalityName(Parser\File\Line $line) : string
    {
        return $this->get($line, 6);
    }

    /**
     * @param Parser\File\Line $line
     * @return string
     */
    public function getPrecinctCode(Parser\File\Line $line) : string
    {
        return $this->get($line, 9);
    }

    /**
     * @param Parser\File\Line $line
     * @return string
     */
    public function getPrecinctName(Parser\File\Line $line) : string
    {
        return $this->get($line, 10);
    }

    /**
     * @param Parser\File\Line $line
     * @return string
     */
    public function getMedium(Parser\File\Line $line) : string
    {
        return $this->get($line, 11);
    }

    /**
     * @param Parser\File\Line $line
     * @return int
     */
    public function getRegisteredVoters(Parser\File\Line $line) : int
    {
        return (int) $this->get($line, 12);
    }

    /**
     * @param Parser\File\Line $line
     * @return string
     */
    public function getPermanentListsVotes(Parser\File\Line $line) : int
    {
        return (int) $this->get($line, 13);
    }

    /**
     * @param Parser\File\Line $line
     * @return int
     */
    public function getAdditionalListsVotes(Parser\File\Line $line) : int
    {
        return (int) $this->get($line, 14);
    }

    /**
     * @param Parser\File\Line $line
     * @return int
     */
    public function getMobileListsVotes(Parser\File\Line $line) : int
    {
        return (int) $this->get($line, 15);
    }

    /**
     * @param Parser\File\Line $line
     * @return int
     */
    public function getVotes(Parser\File\Line $line) : int
    {
        return (int) $this->get($line, 16);
    }

    /**
     * @param Parser\File\Line $line
     * @param string $gender
     * @return array
     */
    public function getAgeGroupsByGender(Parser\File\Line $line, string $gender) : array
    {
        $votes = [];
        $ageRange = range(18, 120, 1);
        foreach ($ageRange as $age) {
            $votes[$age] = $this->get($line, $age + ($gender === 'm' ? 5 : 113));
        }
        return $votes;
    }
}