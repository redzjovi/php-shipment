<?php

namespace redzjovi\shipment\v1\tracking;

class Tracking
{
    protected $courier;

    public function __construct($courier = 'jne')
    {
        switch ($courier) {
            case 'jne':
                $this->courier = new \redzjovi\shipment\v1\tracking\Jne;
                break;
            case 'tiki':
                $this->courier = new \redzjovi\shipment\v1\tracking\Tiki;
                break;
            case 'pos':
                $this->courier = new \redzjovi\shipment\v1\tracking\Pos;
                break;
            default:
                $this->courier = new \redzjovi\shipment\v1\tracking\Jne;
                break;
        }
    }

    public function track($trackingNumber)
    {
        return $this->courier->track($trackingNumber);
    }
}
