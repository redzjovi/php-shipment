## Synopsis
PHP track your shipment.

## Installation
```
composer require redzjovi/shipment
```

## How to use Jne
```
/*
 * @param [string] $trackingNumber
 * @return [array] $result
 * [
 *      'tracking_number' => '011360133141818',
 *      'courier' => 'jne',
 *      'courier_code' => 'REG15',
 *      'tracking_number' => '011360133141818',
 *      'courier' => 'jne',
 *      'courier_code' => 'REG15',
 *      'date' => '01-Jan-1970 (07:00)',
 *      'date_format' => '1970-01-01',
 *      'sender' => 'HD.BODYFITSTATION',
 *      'receiver' => '15 RICKY',
 *      'send_from' => 'JAKARTA',
 *      'send_to' => 'SUKOMANUNGGAL ,SURAB',
 *      'status' => 'ON PROCESS',
 *      'histories' => [
 *          [
 *              'date' => '27-02-2018 18:45:00',
 *              'date_format' => '2018-02-27',
 *              'description' => 'SHIPMENT RECEIVED BY JNE COUNTER OFFICER AT [JAKARTA]'
 *          ],
 *          ...
 *      ],
 * ];
 */
$shipment = new \redzjovi\shipment\v1\tracking\Jne;
$track = $shipment->track('011360133141818');
var_dump($track);
```

## How to use Pos
```
/*
 * @param [string] $trackingNumber
 * @return [array] $result
 * [
 *      'tracking_number' => '15356195691',
 *      'courier' => 'pos',
 *      'courier_code' => 'POS Indonesia (POS)',
 *      'date' => '2016-12-16',
 *      'date_format' => '2016-12-16',
 *      'sender' => '',
 *      'receiver' => '',
 *      'send_from' => '',
 *      'send_to' => ''',
 *      'status' => 'Orang Serumah;',
 *      'histories' => [
 *          [
 *              'date' => '2016-12-16 09:11:50',
 *              'date_format' => '2016-12-16 09:11:50',
 *              'description' => 'POSTING LOKET Jakartautaratelukgong'
 *          ],
 *          ...
 *      ],
 * ];
 */
$shipment = new \redzjovi\shipment\v1\tracking\Pos;
$track = $shipment->track('15356195691');
var_dump($track);
```

## How to use Tiki
```
/*
 * @param [string] $trackingNumber
 * @return [array] $result
 * [
 *      'receipt_number' => '030071590590',
 *      'courier' => 'tiki',
 *      'courier_code' => 'ONS',
 *      'date' => '17-Jul 14:08',
 *      'sender' => 'BODYFITSTATION.COM',
 *      'receiver' => 'MULUK',
 *      'send_from => 'JAKARTA-',
 *      'send_to => 'JL.KYAI SAHLAN 21\/02 MANYAR -GRESIK',
 *      'status' => 'Success / RECEIVED BY: HARIS',
 *      'histories => [
 *          [
 *              'date' => '17-Jul 14:08',
 *              'date_format' => '2017-07-17',
 *              'description' => 'Success / RECEIVED BY: HARIS Di [GRESIK]',
 *          ],
 *          ...
 *      ],
 * ];
 */
$shipment = new \redzjovi\shipment\v1\tracking\Tiki;
$track = $shipment->track('030071590590');
var_dump($track);
```
