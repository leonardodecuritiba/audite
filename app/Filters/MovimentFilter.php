<?php

namespace App\Filters;

use App\Helpers\DataHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentFilter
{
	public $entity;

	public function filter(Request $request)
	{
		set_time_limit(60 * 60 * 5);
		$filter = $this->entity;

		//filtros exatos
		// (unicos)
		if($request->has('cte_number') && ($request->get('cte_number') != '')){
			$filter = $filter->where('cte_number', $request->get('cte_number'));
		}
		// (unicos)
		if($request->has('ctrc') && ($request->get('ctrc') != '')){
			$filter = $filter->where('ctrc', $request->get('ctrc'));
		}
		if($request->has('moviment_freight') && ($request->get('moviment_freight') != '')){
			$filter = $filter->where('freight', $request->get('moviment_freight'));
		}
		if($request->has('document_type') && ($request->get('document_type') != '')){
			$filter = $filter->where('document_type', $request->get('document_type'));
		}
		if($request->has('destiny_unity') && ($request->get('destiny_unity') != '')){
			$filter = $filter->where('destiny_unity', 'like', '%' . $request->get('destiny_unity') . '%');
		}

		if($request->has('partner_id') && ($request->get('partner_id') != '')){
			$filter = $filter->where('partner_id', $request->get('partner_id'));
		}

		if($request->has('period') && ($request->get('period') != '')){
			$now = Carbon::now();
			switch ($request->get('period')){
				case 1:
					$filter = $filter->where('emitted_at', '>', $now->setTime(0,0,0));
					break;
				case 2:
					$filter = $filter->where('emitted_at', '>', $now->subDay(1)->setTime(0,0,0));
					break;
				case 3:
					$filter = $filter->where('emitted_at', '>', $now->subWeek(1)->setTime(0,0,0));
					break;
				case 4:
					$filter = $filter->where('emitted_at', '>', $now->subMonth(1)->setTime(0,0,0));
					break;
				case 5:
					$value = $request->get('emitted_at');
					$value = DataHelper::setDate($value);
					if($value != NULL){
						$filter = $filter->where('emitted_at', '>', $value);
					} else {
						$request->merge(['emitted_at' => $now->format('d/m/Y')]);
						$filter = $filter->where('emitted_at', '>', $now);
					}
					break;
			}
		}

		if($request->has('sender') && ($request->get('sender') != '')){
			$search = $request->get('sender');
			$numbers = DataHelper::getOnlyNumbers($search);
			if ($numbers != '') {
				$ids = DB::table('entities')
					->where('cnpj', 'like', '%' . $numbers . '%')
					->pluck('id');

			} else {
				$ids = DB::table('entities')
		                        ->orWhere('fantasy_name', 'like', '%' . $search . '%')
		                        ->pluck('id');
			}
			$filter = $filter->whereIn('sender_id', $ids);
		}

		if($request->has('receiver') && ($request->get('receiver') != '')){
			$search = $request->get('receiver');
			$numbers = DataHelper::getOnlyNumbers($search);
			if ($numbers != '') {
				$ids = DB::table('receivers')
				        ->where('cnpj', 'like', '%' . $numbers . '%')
						->pluck('id');

			} else {
				$ids = DB::table('receivers')
		                        ->orWhere('fantasy_name', 'like', '%' . $search . '%')
		                        ->pluck('id');
			}
			$filter = $filter->whereIn('receiver_id', $ids);
		}

		if($request->has('payer') && ($request->get('payer') != '')){
			$search = $request->get('payer');
			$numbers = DataHelper::getOnlyNumbers($search);
			if ($numbers != '') {
				$ids = DB::table('entities')
				         ->where('cnpj', 'like', '%' . $numbers . '%')
				         ->pluck('id');

			} else {
				$ids = DB::table('entities')
				         ->orWhere('fantasy_name', 'like', '%' . $search . '%')
				         ->pluck('id');
			}
			$filter = $filter->whereIn('payer_id', $ids);
		}

		if($request->has('fiscal_number') && ($request->get('fiscal_number') != '')){
			$search = $request->get('fiscal_number');
			$numbers = DataHelper::getOnlyNumbers($search);
			if ($numbers != '') {
				$ids = DB::table('invoices')
				         ->where('number', 'like',  $numbers . '%')
//				         ->get();
				         ->pluck('moviment_id');
				$filter = $filter->whereIn('id', $ids);

			}
		}

		return $filter;
	}

	public function map(Request $request, $entity, $pagination = false)
	{
		$this->entity = $entity;
		if($request->has('search') || $request->has('search_id')){
			$filter = $this->filter($request);

			if(!is_a($filter, 'Illuminate\Database\Eloquent\Collection')) {
				$filter = $filter->with(['partner','sender','receiver','payer'])->get()->map( function ( $s ) {
					return [
						'id'                            => $s->id,
						'name'                          => $s->id,
						'emitted_at_formatted'          => $s->emitted_at_formatted,
						'ctrc'                          => $s->ctrc,
						'cte_number'                    => $s->cte_number,

						'sender_text'                   => $s->sender->short_description,
						'sender_document'               => $s->sender->short_document,
						'receiver_text'                 => $s->receiver->short_description,
						'receiver_document'             => $s->receiver->short_document,
						'payer_text'                    => $s->payer->short_description,
						'payer_document'                => $s->payer->short_document,

						'nfs'                           => $s->getInvoicesText(),

						'volume_quantity'               => $s->volume_quantity,
						'weight_calculated_formatted'   => $s->weight_calculated_formatted,
						'value_formatted'               => $s->value_formatted,
						'freight_text'                  => $s->freight_text,
						'document_type_text'            => $s->document_type_text,

						'aliquot_formatted'             => $s->aliquot_formatted,
						'icms_value_formatted'          => $s->icms_value_formatted,
						'freight_value_formatted'       => $s->freight_value_formatted,
						'freight_icms_formatted'        => $s->freight_icms_formatted,

						'destiny_unity'                 => $s->destiny_unity,
						'partner_text'                  => optional($s->partner)->getName(),



//                            <th>Unidade Destino</th>
//                            <th>Parceiro</th>
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
