<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Builder\Part;

class MediumResult implements ResultInterface
{
    /** @var int $urbanVotes */
    private $urbanVotes;
    /** @var int $ruralVotes */
    private $ruralVotes;

    /**
     * @param int $urbanVotes
     * @param int $ruralVotes
     */
    public function __construct(int $urbanVotes, int $ruralVotes)
    {
        $this->urbanVotes = $urbanVotes;
        $this->ruralVotes = $ruralVotes;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'ur' => $this->urbanVotes,
            'ru' => $this->ruralVotes,
        ];
    }
}