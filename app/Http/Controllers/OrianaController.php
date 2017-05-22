<?php

namespace App\Http\Controllers;

use App\Oriana\Oriana;
use Illuminate\Http\Request;

class OrianaController extends Controller
{
    /**
     * @var Oriana
     */
    private $oriana;

    /**
     * Create a new controller instance.
     *
     * @param Oriana $oriana
     */
    public function __construct(Oriana $oriana)
    {
        //
        $this->oriana = $oriana;
    }

    public function currency(Request $request, $currency)
    {
        $inputs = $request->input();

        return $this->oriana->getOneCurrency($currency, $inputs);
    }
}
