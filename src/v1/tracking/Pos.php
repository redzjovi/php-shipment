<?php

namespace redzjovi\shipment\v1\tracking;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Sunra\PhpSimple\HtmlDomParser;

class Pos
{
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
    public function track($trackingNumber = 0)
    {
        $client = new Client();
        $response = $client->request('POST', 'http://carikodepos.com/cek-resi-pos-indonesia/', [
            'form_params' => ['cek' => '', 'resi' => $trackingNumber]
        ]);
        $html = $response->getBody();

        $result = $this->parseDom($html);
        return $result;
    }

    public function parseDom($html)
    {
        $domHtml = HtmlDomParser::str_get_html($html);

        $dom = $domHtml;
        $tr = $dom->find('div[class=table table-striped] table tbody tr');

        // if empty, return false
        if (empty(trim($tr[0]->find('td')[2]->innertext))) { return false; }

        $result['tracking_number'] = trim($tr[0]->find('td')[2]->innertext);
        $result['courier'] = 'pos';
        $result['courier_code'] = trim($tr[2]->find('td')[2]->innertext);
        $result['date'] = $date = trim($tr[3]->find('td')[2]->innertext);
        $result['date_format'] = $date;
        $result['sender'] = trim($tr[4]->find('td')[2]->innertext);
        $result['receiver'] = trim($tr[6]->find('td')[2]->innertext);
        $result['send_from'] = trim($tr[5]->find('td')[2]->innertext);
        $result['send_to'] = trim($tr[7]->find('td')[2]->innertext);
        $result['status'] = trim($tr[1]->find('td')[2]->innertext);

        $result['histories'] = [];
        $dom = $domHtml;
        $trs = $dom->find('table[class=table table-bordered] tbody tr');
        if (count($trs) > 0) {
            foreach ((array) $trs as $i => $tr) {
                $td = $tr->find('td');

                // if empty, continue
                if (empty($td[0]->innertext)) { continue; }

                $result['histories'][$i]['date'] = $date = strip_tags($td[0]->innertext);
                $result['histories'][$i]['date_format'] = $date;
                $city = $td[1]->innertext;
                $information = $td[2]->innertext;
                $result['histories'][$i]['description'] = $information.' '.$city;
            }
        }

        return $result;
    }
}
