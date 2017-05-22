<?php

namespace App\Oriana\Contracts;


class Bitstamp extends BaseContract
{
    protected $base_url = 'https://www.bitstamp.net/api/v2/';
    public $name = 'bitstamp';

    public $support_currency = [
        'btc'  => 'btcusd',
    ];


    public function get($currencies = [], $to = 'USD')
    {
        $values = [];
        if($this->verifyCurrencies($currencies)){
            foreach ($currencies as $key => $currency){
                $tick = $this->support_currency["$currency"];
                $value = $this->request("ticker/$tick", 'last');
                $values[$currency] = $this->converterToFiat($value, $to);
            }
        }

        return $values;
    }

}