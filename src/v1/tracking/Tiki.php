<?php

namespace redzjovi\shipment\v1\tracking;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Sunra\PhpSimple\HtmlDomParser;

class Tiki
{
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
    public function track($trackingNumber = 0)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://tiki.id/resi/'.$trackingNumber);
        $html = $response->getBody();

        $result = $this->parseDom($html);
        return $result;
    }

    public function parseDom($html)
    {
        $domHtml = HtmlDomParser::str_get_html($html);

        $dom = $domHtml;
        $dom = $dom->find('div[id=heading0] div span');
        if (! isset($dom[1])) {
            return false;
        }
        $dom = $dom[1]->innertext;
        if ($dom == 'Tidak ada tracking') {
            return false;
        }

        $dom = $domHtml;
        $dom = $dom->find('div[id=heading0] div h4');
        $dom = $dom[0]->innertext;
        $dom = explode('&nbsp;', $dom);
        $dom = trim(reset($dom));
        $result['receipt_number'] = $dom;

        $result['courier'] = 'tiki';

        $dom = $domHtml;
        $dom = $dom->find('div[id=heading0] div h4 span');
        $dom = $dom[0]->innertext;
        $result['courier_code'] = $dom;

        $dom = $domHtml;
        $dom = $dom->find('div[id=heading0] div span[class=pull-right hidden-xs hidden-sm] small');
        $dom = $dom[0]->innertext;
        $dom = explode('</i>', $dom);
        $dom = trim(end($dom));
        $result['date'] = $dom;
        $result['date_format'] = '';

        $dom = $domHtml;
        $dom = $dom->find('div[id=collapse0] div table tbody tr td b');
        $result['sender'] = $dom[0]->innertext;
        $result['receiver'] = $dom[1]->innertext;

        $dom = $domHtml;
        $dom = $dom->find('div[id=collapse0] div table tbody tr td small');
        $result['send_from'] = $dom[0]->innertext;
        $result['send_to'] = $dom[1]->innertext;

        $dom = $domHtml;
        $dom = $dom->find('div[id=heading0] div span');
        $dom = $dom[2]->innertext;
        $dom = explode('&nbsp;', $dom);
        $dom = $dom[2];
        $dom = explode('<small', $dom);
        $dom = trim($dom[0]);
        $result['status'] = $dom;

        $result['histories'] = [];
        $dom = $domHtml;
        $dom = $dom->find('ul[class=timeline] li');
        foreach ((array) $dom as $i => $li) {
            $dom = $li->find('div[class=timeline-body] small');
            $dom = $dom[0]->innertext;
            $dom = explode('</i>', $dom);
            $dom = trim(end($dom));
            $result['histories'][$i]['date'] = $date = $dom;
            $result['histories'][$i]['date_format'] = Carbon::createFromFormat('d-M H:i', $date)->toDateString();;

            $dom = $li->find('div[class=timeline-body] p');
            $dom = $dom[0]->innertext;
            $dom = trim($dom);
            $status = $dom;

            $dom = $li->find('div[class=timeline-heading] h4');
            $dom = $dom[0]->innertext;
            $dom = trim($dom);
            $location = $dom;

            $result['histories'][$i]['description'] = $status.' '.$location;
        }

        return $result;
    }
}
