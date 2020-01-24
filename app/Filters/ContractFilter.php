<?php

namespace App\Filters;

use App\Helpers\DataHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractFilter
{
	public $entity;

	public function filter(Request $request)
	{
		set_time_limit(60 * 60 * 5);
		$filter = $this->entity;

		$fields = ['status','cost_type'];

		foreach($fields as $f){
			if($request->has($f) && ($request->get($f) != '')){
				$filter = $filter->where($f, $request->get($f));
			}
		}

		if($request->has('start_value') && ($request->get('start_value') != '')){
			$value = DataHelper::getReal2Float($request->get('start_value'));
			$filter = $filter->where('value','>=', $value);
		}

		if($request->has('end_value') && ($request->get('end_value') != '')){
			$value = DataHelper::getReal2Float($request->get('end_value'));
			$filter = $filter->where('value','<=', $value);
		}


		if($request->has('start_at') && ($request->get('start_at') != '')){
			$value = DataHelper::setDate($request->get('start_at'));
			$filter = $filter->where('created_at','>=', $value);
		}

		if($request->has('end_at') && ($request->get('end_at') != '')){
			$value = DataHelper::setDate($request->get('end_at'));
			$filter = $filter->where('created_at','<=', $value);
		}

		if($request->has('contract_partner_type') && ($request->get('contract_partner_type') != '')){
			if($request->get('contract_partner_type')==1){ //VEÍCULO
				$field = 'vehicle_id';
			} else {
				$field = 'conveyor_id';
			}
			$filter = $filter->where($field, $request->get('partner_id'));
		}

		return $filter;
	}

	public function map(Request $request, $entity, $pagination = false)
	{
		$this->entity = $entity;
		if($request->has('search') || $request->has('search_id')){
			$filter = $this->filter($request);

			if(!is_a($filter, 'Illuminate\Database\Eloquent\Collection')) {
//					->with(['partner','sender','receiver','payer'])
				$filter = $filter->get()->map( function ( $s ) {
					return [
						'id'                        => $s->id,
						'name'                      => $s->description,
						'description'               => $s->description,
						'cost_type_text'            => $s->cost_type_text,
						'value_currency'            => $s->value_currency,
						'payment_form'              => $s->payment_form,

						'status_array'              => $s->status_array,

						'created_at'                => $s->created_at_formatted,
						'created_at_time'           => $s->created_at_time,

					];
				} );
			};
		} else {
			$filter = NULL;
		}

		if($filter != NULL){
			if($pagination){
				return [
					'filter'=>$filter,
					'items' =>$filter->getCollection()->transform(function($s){
						return $s;
					})
				];
			}
			return $filter->map(function($s){
				return $s;
			});
		} else {
			return [];
		}
	}

}
