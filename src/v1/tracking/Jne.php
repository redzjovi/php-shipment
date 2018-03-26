<?php

namespace redzjovi\shipment\v1\tracking;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Sunra\PhpSimple\HtmlDomParser;

class Jne
{
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
    public function track($trackingNumber = 0)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://jnetaruna.com/tracking', [
            'query' => ['no' => $trackingNumber]
        ]);
        $html = $response->getBody();

        $result = $this->parseDom($html);
        return $result;
    }

    public function parseDom($html)
    {
        $domHtml = HtmlDomParser::str_get_html($html);

        $dom = $domHtml;
        $divColMd7 = $dom->find('div[class=col-md-7 value]');

        // if empty, return false
        if (empty(trim($divColMd7[0]->innertext))) { return false; }

        $result['tracking_number'] = trim($divColMd7[0]->innertext);
        $result['courier'] = 'jne';
        $result['courier_code'] = trim($divColMd7[3]->innertext);
        $result['date'] = trim($divColMd7[1]->innertext);
        $result['date_format'] = Carbon::createFromFormat('d-M-Y (H:i)', trim($divColMd7[1]->innertext))->toDateString();

        $dom = $domHtml;
        $table = $dom->find('table[class=table table-striped table-bordered table-hover]');
        $td = $table[0]->find('tbody tr td b');
        $result['sender'] = $td[0]->innertext;
        $td = $table[1]->find('tbody tr td b');
        $result['receiver'] = $td[0]->innertext;

        $result['send_from'] = trim($divColMd7[4]->innertext);
        $result['send_to'] = trim($divColMd7[5]->innertext);
        $result['status'] = trim($divColMd7[6]->innertext);

        $result['histories'] = [];
        if (isset($table[2])) {
            $trs = $table[2]->find('tbody tr');
            foreach ((array) $trs as $i => $tr) {
                $td = $tr->find('td');

                // if empty, continue
                if (empty($td[0]->innertext)) { continue; }

                $result['histories'][$i]['date'] = $date = strip_tags($td[0]->innertext);
                $result['histories'][$i]['date_format'] = Carbon::createFromFormat('d-m-Y H:i:s', $date)->toDateString();
                $result['histories'][$i]['description'] = strip_tags($td[1]->innertext);
            }
        }

        return $result;
    }
}
