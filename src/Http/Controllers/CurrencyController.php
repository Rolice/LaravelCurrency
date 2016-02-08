<?php
namespace Rolice\LaravelCurrency\Http\Controllers;

use Illuminate\Routing\Controller;
use Rolice\LaravelCurrency\Models\Currency;
use Rolice\LaravelCurrency\Http\Requests\CurrencyListRequest;

class CurrencyController extends Controller
{

    public function index(CurrencyListRequest $request)
    {
        return Currency::all();
    }

}