<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Builder;

class PartFactory
{
    /**
     * @param string $code
     * @param string $name
     * @return Part
     */
    public function createPart(string $code, string $name)
    {
        return new Part($code, $name);
    }

    /**
     * @param int $registered
     * @param int $total
     * @return Part\OverallResult
     */
    public function createPrecinctOverallResult(int $registered, int $total)
    {
        return new Part\OverallResult($registered, $total);
    }

    /**
     * @param int $urbanVotes
     * @param int $ruralVotes
     * @return Part\MediumResult
     */
    public function createPrecinctMediumResult(int $urbanVotes, int $ruralVotes)
    {
        return new Part\MediumResult($urbanVotes, $ruralVotes);
    }

    /**
     * @param int $permanent
     * @param int $additional
     * @param int $mobile
     * @return Part\ListTypeResult
     */
    public function createPrecinctListTypeResult(int $permanent, int $additional, int $mobile)
    {
        return new Part\ListTypeResult($permanent, $additional, $mobile);
    }

    /**
     * @param string $gender
     * @return Part\GroupResult
     */
    public function createPrecinctGroupResult(string $gender)
    {
        return new Part\GroupResult($gender);
    }
}