<?php

namespace App\Http\Requests\Moviments;

use Illuminate\Foundation\Http\FormRequest;

class CityPriceTableRequest extends FormRequest {
	private $table = 'price_tables';

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {

		return [
            'cities'      => 'required',
        ];
	}
    public function messages()
    {
        return [
            'cities.required' => 'A escolha da cidade é obrigatória',
        ];
    }
}

