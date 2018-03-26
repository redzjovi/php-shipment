<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// $shipment = new \redzjovi\shipment\v1\tracking\Jne;
// $track = $shipment->track('011360133141818');
// dump($track);

// $shipment = new \redzjovi\shipment\v1\tracking\Pos;
// $track = $shipment->track('15356195691');
// dump($track);

// $shipment = new \redzjovi\shipment\v1\tracking\Tiki;
// $track = $shipment->track('030071590590');
// dump($track);

$shipment = new \redzjovi\shipment\v1\tracking\Tracking('pos');
$track = $shipment->track('15356195691');
dump($track);
