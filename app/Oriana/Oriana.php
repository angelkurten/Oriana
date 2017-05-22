<?php

namespace App\Oriana;

use App\Oriana\Contracts\Bitfinex;
use App\Oriana\Contracts\Bitstamp;
use App\Oriana\Contracts\Cryptropay;
use App\Oriana\Contracts\Localcoins;
use App\Oriana\Contracts\Poloniex;
use App\Oriana\Contracts\Surbtc;
use App\Oriana\Security\Polices;

class Oriana
{
    use Polices;

    protected $contracts = [
        'bitstamp' => Bitstamp::class,
        'poloniex'   => Poloniex::class,
        //Localcoins::class,
        //Cryptropay::class,
        'bitfinex' => Bitfinex::class,
    ];

    protected $objs = [];

    public function getOneCurrency($currency, $inputs)
    {
        $this->verifyInputs($inputs);
        $this->verifyExchanges();
        $this->supportCurrency($currency);

        return $this->run([$currency]);
    }

    public function run($currency)
    {
        $data = [];
        foreach ($this->objs as $key => $obj)
        {
            if (is_object($obj)){
                $data[$obj->name] = $obj->get($currency);
            } else {
                $data[$key] = $obj;
            }
        }

        return $data;
    }
}