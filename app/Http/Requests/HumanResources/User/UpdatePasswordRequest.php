<?php

namespace App\Http\Requests\HumanResources\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest {
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
		if($this->has('user_password')){
			return [
				'user_password' => 'required|string|min:6|confirmed',
			];
		}
		return [
			'password' => 'required|string|min:6|confirmed',
		];

	}
}

