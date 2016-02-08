<?php
namespace Rolice\LaravelCurrency\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
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
        $amount = (float)Input::get('amount') ?: 1;

        if (!$from || !$to) {
            return response()->json(Lang::get('currency.error.not_found'))->setStatusCode(404, 'Currency Not Found');
        }

        if ($from->base === $to->code) {
            return $amount / $from->price;
        }

        if ($to->base = $from->code) {
            return $amount * $from->price;
        }

        if ($from->base !== $to->base) {
            throw new Exception('Cannot convert currencies with different bases.');
        }

        return ($amount / $from->price) * $to->price;
    }

}