## Synopsis
PHP track your Tiki.

## Installation
```
composer require redzjovi/tiki
```

## How to use
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
