<?php

namespace redzjovi\shipment\v1\delivery;

class Weight
{
    protected $courier;

    public function __construct($courier = 'jne')
    {
        switch ($courier) {
            case 'jne':
                $this->courier = new \redzjovi\shipment\v1\delivery\Jne;
                break;
            default:
                $this->courier = new \redzjovi\shipment\v1\delivery\Jne;
                break;
        }
    }

    public function roundUp($weight)
    {
        return $this->courier->weightRoundUp($weight);
    }
}
