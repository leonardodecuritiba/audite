<?php

namespace App\Http\Requests\Moviments;

use Illuminate\Foundation\Http\FormRequest;

class ConveyorRequest extends FormRequest {
	private $table = 'conveyors';

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
			'initials'  => 'required|min:1|max:3|unique:'.$this->table.',initials,NULL,id,deleted_at,NULL',
			'type'      => 'required',
			'social_reason'      => 'required|min:3|max:100',
        ];
		if($this->get('type')){
            $rules['cnpj'] = 'required|min:3|max:20|unique:'.$this->table.',cnpj,NULL,id,deleted_at,NULL';
        } else {
            $rules['cpf'] = 'required|min:3|max:20|unique:'.$this->table.',cpf,NULL,id,deleted_at,NULL';
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

                    if($this->get('type')){
                        $rules['cnpj'] = 'required|min:3|max:20|unique:'.$this->table.',cnpj,' . $this->conveyor . ',id,deleted_at,NULL';
                    } else {
                        $rules['cpf'] = 'required|min:3|max:20|unique:'.$this->table.',cpf,' . $this->conveyor . ',id,deleted_at,NULL';
                    }
				    $rules['initials'] = 'required|min:1|max:3|unique:'.$this->table .',initials,'.$this->conveyor . ',id,deleted_at,NULL';

					return $rules;
				}
			default:
				break;
		}
	}
}

