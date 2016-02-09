<?php
namespace Rolice\LaravelCurrency\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Rolice\LaravelCurrency\Exceptions\Exception;
use Rolice\LaravelCurrency\Models\Currency;

class CurrencyController extends Controller
{

    public function index()
    {
        return Currency::all();
    }

    public function convert()
    {
        $validator = Validator::make(Input::all(), [
            'from' => 'required|min:3|max:3',
            'to' => 'required|min:3|max:3',
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()])->setStatusCode(422, 'Validation Failed');
        }

        $from = Currency::find(Input::get('from'));
        $to = Currency::find(Input::get('to'));
        $precision = pow(10, (int) Config::get('laravel-currency.laravel-currency.precision'));
        $amount = (float)Input::get('amount') ?: 1;
        $amount = round($amount * $precision);

        if ($from && ($from->base == Input::get('to') || $from->base === $to->code)) {
            return round(($amount / $from->price) / $precision, 2);
        }

        if ($to && ($to->base == Input::get('from') || $to->base = $from->code)) {
            return round($amount * $to->price / $precision, 2);
        }

        if (!$from || !$to) {
            return response()->json(['error' => Lang::get('currency.error.not_found')])->setStatusCode(404, 'Currency Not Found');
        }

        if ($from->base !== $to->base) {
            throw new Exception('Cannot convert currencies with different bases.');
        }

        return ($amount / $from->price) * $to->price  / $precision;
    }

}