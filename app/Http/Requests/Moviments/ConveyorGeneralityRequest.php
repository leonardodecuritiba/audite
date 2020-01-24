<?php

namespace App\Http\Requests\Moviments;

use Illuminate\Foundation\Http\FormRequest;

class ConveyorGeneralityRequest extends FormRequest {
	private $table = 'conveyor_generalities';

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

	    if($this->get('conveyor_generality_type') == 'percent'){
	        $rules = [
                'generality_type'   => 'required',
                'value_percent'     => 'required',
            ];
        } else {
            $rules = [
                'generality_type'   => 'required',
                'value'             => 'required',
            ];
        }
        return $rules;

        /*

	    if($this->get('conveyor_generality_id') != NULL){
            return [
                'value'      => 'required',
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

