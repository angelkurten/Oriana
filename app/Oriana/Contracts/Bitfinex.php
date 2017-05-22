<?php

namespace App\Oriana\Contracts;


class Bitfinex extends BaseContract
{
    public $name = 'bitfinex';

    protected $base_url = 'https://api.bitfinex.com/v2/';

    public $support_currency = [
        'btc'  => 'BTCUSD',
        'dash' => 'DSHUSD',
        'eth'  => 'ETHUSD',
        'zec'  => 'ZECUSD',
        'xmr'  => 'XMRUSD',
        'ltc'  => 'LTCUSD'
    ];

    public function get($currencies = [], $to = 'USD')
    {
        $values = [];
        if($this->verifyCurrencies($currencies)){
            foreach ($currencies as $key => $currency){
                $tick = $this->support_currency["$currency"];
                $value = $this->requestWithoutKey("tickers?symbols=t$tick")[0][9];
                $values[$currency] = $this->converterToFiat($value, $to);
            }
        }

        return $values;
    }

}