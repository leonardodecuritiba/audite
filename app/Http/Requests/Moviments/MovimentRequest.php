<?php

namespace App\Http\Requests\Moviments;

use Illuminate\Foundation\Http\FormRequest;

class MovimentRequest extends FormRequest {
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


        $rules = [
            'ctrc'              => 'required|min:1|max:20',
            'cte_number'        => 'required|min:1|max:20',
            'document_type'     => 'required', //variables
            'emitted_at'        => 'required',
            'cte_key'           => 'required|min:1|max:60',

            'sender_id'         => 'required|exists:entities,id',
            'dispatcher_id'     => 'required|exists:entities,id',
            'payer_id'          => 'required|exists:entities,id',
            'receiver_id'       => 'required|exists:receivers,id',

            'real_weight'       => 'required|min:1',
            'cubage'            => 'required|min:1',
            'volume_quantity'   => 'required|min:1',
            'freight'           => 'required|min:1',

            'commodity_id'      => 'required|exists:commodities,id',
            'specie_id'         => 'required|exists:species,id',

            'value'             => 'required|min:1',
            'calculus_type'     => 'required', //variables

//            'calculus_table'    => 'required',
            'freight_value'     => 'required|min:1',

            'freight_icms'      => 'required|min:1',
            'calculus_basis'    => 'required|min:1',
            'icms_value'        => 'required|min:1',
            'aliquot'           => 'required|min:1',

            'iss_value'         => 'required|min:1',
            'weight_calculated' => 'required|min:1',
            'modality_id'       => 'required|exists:modalities,id',
            'weight_freight'    => 'required|min:1',

            'value_freight'     => 'required|min:1',
            'despatch'          => 'required|min:1',
            'cat'               => 'required|min:1',
            'itr'               => 'required|min:1',
            'gris'              => 'required|min:1',
            'toll'              => 'required|min:1',
            'tas'               => 'required|min:1',
            'tda'               => 'required|min:1',

            'suframa'           => 'required|min:1',
            'others'            => 'required|min:1',
            'collect'           => 'required|min:1',
            'tdc'               => 'required|min:1',
            'tde'               => 'required|min:1',
            'tar'               => 'required|min:1',
            'trt'               => 'required|min:1',

            'last_occurrence_code'  => 'required|min:1',
            'delivery_prevision'    => 'required',


        ];

        return $rules;

	}
}

