<?php

namespace CatalinMoiceanu\ElectionDataProcessor\Builder\Part;

class ListTypeResult implements ResultInterface
{
    /** @var int $permanent */
    private $permanent;
    /** @var int $additional */
    private $additional;
    /** @var int $mobile */
    private $mobile;

    /**
     * @param int $permanent
     * @param int $additional
     * @param int $mobile
     */
    public function __construct(int $permanent, int $additional, int $mobile)
    {
        $this->permanent = $permanent;
        $this->additional = $additional;
        $this->mobile = $mobile;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'l_p' => $this->permanent,
            'l_a' => $this->additional,
            'l_m' => $this->mobile,
        ];
    }
}