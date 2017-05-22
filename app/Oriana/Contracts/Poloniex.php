<?php

namespace App\Oriana\Contracts;


class Poloniex extends BaseContract
{
    public $name = 'poloniex';

    protected $base_url = 'https://poloniex.com/public/';

    public $support_currency = [
        'btc'   => 'USDT_BTC',
        'dash'  => 'USDT_DASH',
        'eth'  => 'USDT_ETH',
    ];

    public function get($currencies = [], $to = 'USD')
    {
        $values = [];
        if($this->verifyCurrencies($currencies)){
            foreach ($currencies as $key => $currency){
                $tick = $this->support_currency["$currency"];
                $value = $this->request("?command=returnTicker", $tick)->last;
                $values[$currency] = $this->converterToFiat($value, $to);
            }
        }

        return $values;
    }

}