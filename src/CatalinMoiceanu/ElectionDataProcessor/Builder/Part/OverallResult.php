<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Builder\Part;

class OverallResult implements ResultInterface
{
    /** @var int $registered */
    private $registered;
    /** @var int $total */
    private $total;
    /** @var float|null $presence */
    private $presence;

    /**
     * @param int $registered
     * @param int $total
     */
    public function __construct(int $registered, int $total)
    {
        $this->registered = $registered;
        $this->total = $total;
        $this->presence = $registered ? round($total/$registered*100, 2) : null;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'r' => $this->registered,
            't' => $this->total,
            'p' => $this->presence,
            'ab' => max($this->registered - $this->total, 0)
        ];
    }
}