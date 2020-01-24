<?php

namespace App\Http\Requests\Moviments;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest {
	private $table = 'contracts';

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
        $rules = [
	        'cost_type'             => 'required|min:1|max:6',
	        'value'                 => 'required|min:1',
	        'contract_partner_type' => 'required|min:1|max:6',

	        'partner_id'            => 'required',
            'description'           => 'required|min:1|max:100',
	        'contracted_at'         => 'required',
	        'realized_at'           => 'required',

	        'payment_form'          => 'required|min:1|max:100',
	        'payment_date'          => 'required',
		];
		switch ( $this->method() ) {
			case 'GET':
			case 'DELETE':
			{
				return [];
			}
			case 'POST':
			{
				return $rules;
			}
			case 'PUT':
			case 'PATCH':
			{
				return $rules;
			}
			default:
				break;
		}

	}
}

