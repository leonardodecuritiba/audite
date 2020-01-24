<?php

namespace App\Http\Requests\Moviments;

use Illuminate\Foundation\Http\FormRequest;

class PriceTableRequest extends FormRequest {
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

		if($this->has('price_type')){
			//novo
			$rules = [
				'price_type'      => 'required',
				'description'      => 'required',
				'priority_type'      => 'required',
			];
		} else {
			$rules = [
				'description'      => 'required',
				'priority_type'      => 'required',
			];
		}
		return $rules;
	}
}

