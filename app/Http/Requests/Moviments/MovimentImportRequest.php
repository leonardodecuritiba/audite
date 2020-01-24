<?php

namespace App\Http\Requests\Moviments;

use Illuminate\Foundation\Http\FormRequest;

class MovimentImportRequest extends FormRequest {
	private $table = 'moviments';

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

		$rules = [];
        if($this->has('file_import') && $this->file('file_import') != NULL){
            $size = config('system.spreadsheets.size') * 1000;
            $rules['file_import'] = 'max:' . $size . '|mimetypes:'  . config('system.spreadsheets.mimetypes');
        }

        switch ( $this->method() ) {
            case 'PATCH':
            case 'POST':
                {
                    return $rules;
                }
            default:
                return [];
        }

	}
}

