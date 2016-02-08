<?php
namespace Rolice\LaravelCurrency\Http\Requests;

use Illuminate\Config;
use Illuminate\Http\Request;

class CurrencyListRequest extends Request
{

    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $db = Config::get('econt.connection');

        return [
            'from' => 'required|min:3|max:3',
            'to' => 'required|min:3|max:3',
        ];
    }

}