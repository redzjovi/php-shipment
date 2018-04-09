<?php

namespace redzjovi\shipment\v1\delivery;

use redzjovi\php\MathHelper;

class Jne
{
    public function weightRoundUp($weight)
    {
        return MathHelper::roundUp($weight, 0.29);
    }
}
