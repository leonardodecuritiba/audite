<?php

namespace App\Http\Requests\HumanResources;

use App\Models\HumanResources\Client;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest {
	private $table = 'clients';

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


        if($this->get('type')){ //1:pj
            $rules = [
                'fantasy_name'  => 'required|min:3|max:100',
                'social_reason' => 'required|min:3|max:100',
            ];
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

                    if($this->get('type')){ //1:pj
                        $rules['cnpj'] = 'min:1|max:20|unique:clients,cnpj';
                        $rules['code'] = 'min:1|max:20|unique:clients,code';
                    } else {
                        $rules['cpf'] = 'min:1|max:20|unique:clients,cpf';
                    }
					return $rules;
				}
			case 'PUT':
			case 'PATCH':
				{

                    if($this->get('type')){ //1:pj
                        $rules['cnpj'] = 'required|min:3|max:20|unique:'.$this->table.',cnpj,' . $this->client . ',id';
                    } else {
                        $rules['cpf'] = 'required|min:3|max:20|unique:'.$this->table.',cpf,' . $this->client . ',id';
                    }

					return $rules;
				}
			default:
				break;
		}
	}
}

