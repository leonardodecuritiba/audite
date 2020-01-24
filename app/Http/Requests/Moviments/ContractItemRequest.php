<?php

namespace App\Http\Requests\Moviments;

use Illuminate\Foundation\Http\FormRequest;

class ContractItemRequest extends FormRequest {
	private $table = 'contract_items';

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
			'moviment_id'   => 'required',
		];
		/*
	    if($this->get('contract_item_id') != NULL){
            return [
                'moviment_id'   => 'required',
            ];
        } else {

            return [
                'type'      => 'required',
                'value'      => 'required',
            ];
        }
		*/
	}
}

