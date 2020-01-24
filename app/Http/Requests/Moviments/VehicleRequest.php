<?php

namespace App\Http\Requests\Moviments;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest {
	private $table = 'vehicles';

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
			'plate'             => 'required|min:7|max:7',
			'contract_type'     => 'required',
			'vehicle_type'      => 'required',
			'bodywork_type'     => 'required',
            'owner_name'        => 'required|min:3|max:100',
            'driver_name'       => 'required|min:3|max:100',
//            'brand'             => 'required|min:3|max:100',
//            'model'             => 'required|min:3|max:100',
		];


		if ( $this->get( 'owner_type' ) ) { //juridica
			$rules['owner_cnpj'] = 'required|min:3|max:20';
		} else { //fisica
			$rules['owner_cpf'] = 'required|min:3|max:20';
		}

		if ( $this->get( 'driver_type' ) ) { //juridica
			$rules['driver_cnpj'] = 'required|min:3|max:20';
		} else { //fisica
			$rules['driver_cpf'] = 'required|min:3|max:20';
		}

//		dd($rules);
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

