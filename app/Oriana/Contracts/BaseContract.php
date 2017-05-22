<?php

namespace App\Oriana\Contracts;

use GuzzleHttp\Client;


class BaseContract
{
    protected $base_url;
    protected $name;
    protected $support_currency = [];


    protected function request($url, $key, $type = 'get', $options = [])
    {
        $client = new Client(['base_uri' => $this->base_url, $options]);

        return $this->response($client, $type, $url)->$key;
    }

    protected function requestWithoutKey($url, $type = 'get', $options = [])
    {
        $client = new Client(['base_uri' => $this->base_url, $options]);
        return $this->response($client, $type, $url);
    }

    protected function requestSetBody($url, $type = 'get', $options = [], $body)
    {
        $client = new Client(['base_uri' => $this->base_url, $options]);
        return $this->response($client, $type, $url);
    }

    private function response($client, $type, $url)
    {
        return json_decode($client->request($type, $url)->getBody()->getContents());
    }

    protected function converterToFiat($value, $to = 'USD', $from = 'USD')
    {
        if($to == 'USD' and $from == 'USD'){
            return $value;
        }

        $get = file_get_contents("https://www.google.com/finance/converter?a=$value&from=$from&to=$to");
        $get = explode("<span class=bld>",$get);
        $get = explode("</span>",$get[1]);
        return preg_replace("/[^0-9\.]/", null, $get[0]);
    }

    protected function verifyCurrencies($currencies){
        foreach ($currencies as $currency)
        {
            if(!array_key_exists(strtolower($currency), $this->support_currency)){
                return false;
            }
        }

        return true;
    }

}