<?php

namespace App\Oriana\Security;


trait Polices
{
    protected $inputs = [
        'convert_to' => 'USD',
        'convert_from' => 'USD',
        'exchange' => 'ALL'
    ];

    protected function verifyInputs($inputs = [])
    {
        $this->inputs = array_intersect_key($this->inputs, $inputs);

        foreach ($inputs as $input => $value){
            if(empty($value) or is_null($value)){
                unset($this->inputs[$input]);
            }

            if(!array_key_exists($input, $this->inputs))
            {
                return false;
            }

            $this->inputs[$input] = $value;
        }

        return true;
    }

    protected function verifyExchanges()
    {
        if(isset($this->inputs['exchange'])){
            $exchanges = explode('|', $this->inputs['exchange']);

            foreach ($exchanges as $exchange){
                if(array_key_exists($exchange, $this->contracts)){
                    $this->objs[$exchange] = new $this->contracts[$exchange];
                } else {
                    $this->objs[$exchange] = 'Not exists contract for exchange';
                }
            }
        } else {
            foreach ($this->contracts as $exchange) {
                $this->objs[] = new $exchange;
            }
        }

        return $this->objs;
    }

    protected function supportCurrency($currency){

        foreach ($this->objs as $exchange){
            if(is_object($exchange)){
                if (!array_key_exists($currency, $exchange->support_currency)){
                    $this->objs[$exchange->name] = 'Not support cryptocurrency';
                }
            }
        }

    }

}