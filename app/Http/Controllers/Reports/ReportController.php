<?php

namespace App\Http\Controllers\Reports;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\ContractRequest;
use App\Models\Commons\CepStates;
use App\Models\Moviments\Commons\Entity;
use App\Models\Moviments\Contract;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\Moviment;
use App\Models\Moviments\Settings\ContractPartnerTypes;
use App\Models\Moviments\Settings\CostTypes;
use App\Models\Moviments\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ReportController extends Controller {

	public $entity = "reports";
	public $sex = "M";
	public $name = "Relatório";
	public $names = "Relatórios";
	public $main_folder = 'pages.reports';
	public $page = [];
	public $ClientFilter;

	public function __construct( Route $route ) {
		$this->page = (object) [
			'entity'      => $this->entity,
			'main_folder' => $this->main_folder,
			'name'        => $this->name,
			'names'       => $this->names,
			'sex'         => $this->sex,
			'auxiliar'    => array(),
			'response'    => array(),
			'title'       => '',
			'create_option' => 0,
			'subtitle'    => '',
			'noresults'   => '',
			'tab'         => 'data',
			'breadcrumb'  => array(),
		];
		$this->breadcrumb( $route );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return View
	 */

	public function cte(Request $request) {
	    if($request->has('search') && $request->has('cte_number') && $request->get('cte_number') != ""){

            $CostTypes = CostTypes::all();
            $ContractPartnerTypes = ContractPartnerTypes::all();
            $Vehicles = Vehicle::all();
            $Conveyors = Conveyor::all();

            $query = DB::table('contract_items')
                ->join('moviments', 'moviments.id','contract_items.moviment_id')
                ->join('contracts', 'contracts.id','contract_items.contract_id')
                ->where('moviments.cte_number','like',$request->get('cte_number').'%')
                ->get([
                    'moviments.cte_number',
                    'moviments.freight_icms',
                    'contract_items.id',
                    'contract_items.moviment_id',
                    'contract_items.contract_id',
                    'contract_items.pondered_value',

                    'contracts.cost_type',
                    'contracts.contract_partner_type',
                    'contracts.vehicle_id',
                    'contracts.conveyor_id',
                    'contracts.created_at',
                ]);

            $gp = $query->groupBy('cte_number');

            foreach($gp as $key => $g){
                $income     = $g->first()->freight_icms;
                $cost       = $g->sum('pondered_value');
                $result     = ($income - $cost);
                $percent    = round(($result / $income ) * 100, 2);

//                $distributed_value = $g->sum('distributed_value');

                $data[] = [
                    'text'                  => $key,
                    'moviment_id'           => $g->first()->moviment_id,

                    'income'                => $income,
                    'income_formatted'      => DataHelper::getFloat2Currency($income),

                    'cost'                  => $cost,
                    'cost_formatted'        => DataHelper::getFloat2Currency($cost),

                    'result'                => $result,
                    'result_formatted'      => DataHelper::getFloat2Currency($result),

                    'percent'               => $percent,
                    'percent_formatted'     => DataHelper::getFloat2Percent($percent),

                    'items'                 => $g->map(function ($i) use ($CostTypes, $ContractPartnerTypes, $Vehicles, $Conveyors){
                        if($i->contract_partner_type == 1){
                            $partner = optional($Vehicles->find($i->vehicle_id))->getName();
                        } else if($i->contract_partner_type == 2){
                            $partner = optional($Conveyors->find($i->conveyor_id))->getName();
                        }

                        $cost_type = $CostTypes->firstWhere('id', $i->cost_type);
                        $contract_partner_type = $ContractPartnerTypes->firstWhere('id', $i->contract_partner_type);

                        return [
                            'id'                            => $i->id,
                            'created_at'                    => DataHelper::getPrettyDateTime($i->created_at),
                            'value'                         => $i->pondered_value,
                            'value_formatted'               => DataHelper::getFloat2Currency($i->pondered_value),
                            'cost_type_text'                => $cost_type['description'],
                            'contract_partner_type_text'    => $contract_partner_type['description'],
                            'partner_text'                  => ($partner == NULL) ? "NÃO DEFINIDO" : $partner,
                        ];
                    })
                ];
            }

//            return $data;
        } else {
	        $data = [];
        }

        $this->page->response = $data;
		$this->page->title      = 'Custo por CTe';
		$this->page->subtitle   = 'Custo por CTe';

		return view('pages.reports.cte' )
			->with( 'Page', $this->page );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return View
	 */

	public function nf(Request $request) {
	    if($request->has('search') && $request->has('nf') && $request->get('nf') != ""){

            $CostTypes = CostTypes::all();
            $ContractPartnerTypes = ContractPartnerTypes::all();
            $Vehicles = Vehicle::all();
            $Conveyors = Conveyor::all();

            $query = DB::table('contract_items')
                ->join('moviments', 'moviments.id','contract_items.moviment_id')
                ->join('contracts', 'contracts.id','contract_items.contract_id')
                ->join('invoices', 'invoices.moviment_id','moviments.id')
                ->where('invoices.number','like',$request->get('nf').'%')
                ->get([
                    'contract_items.id',
                    'contract_items.moviment_id',
                    'contract_items.contract_id',
                    'contract_items.distributed_value',
                    'invoices.serie',
                    'invoices.number',
                    'moviments.freight_icms',
//                    'contract_items.distributed_value'

                    'contracts.cost_type',
                    'contracts.contract_partner_type',
                    'contracts.vehicle_id',
                    'contracts.conveyor_id',
                    'contracts.created_at',
                ]);


            $gp = $query->groupBy('number');


            foreach($gp as $key => $g){
                $income     = $g->first()->freight_icms;
                $cost       = $g->sum('distributed_value');
                $result     = ($income - $cost);
                $percent    = round(($result / $income ) * 100, 2);

                $data[] = [
                    'text'                  => $g->first()->serie . '/' . $key,
                    'moviment_id'           => $g->first()->moviment_id,

                    'income'                => $income,
                    'income_formatted'      => DataHelper::getFloat2Currency($income),

                    'cost'                  => $cost,
                    'cost_formatted'        => DataHelper::getFloat2Currency($cost),

                    'result'                => $result,
                    'result_formatted'      => DataHelper::getFloat2Currency($result),

                    'percent'               => $percent,
                    'percent_formatted'     => DataHelper::getFloat2Percent($percent),

                    'items'                 => $g->map(function ($i) use ($CostTypes, $ContractPartnerTypes, $Vehicles, $Conveyors){
                        if($i->contract_partner_type == 1){
                            $partner = optional($Vehicles->find($i->vehicle_id))->getName();
                        } else if($i->contract_partner_type == 2){
                            $partner = optional($Conveyors->find($i->conveyor_id))->getName();
                        }

                        $cost_type = $CostTypes->firstWhere('id', $i->cost_type);
                        $contract_partner_type = $ContractPartnerTypes->firstWhere('id', $i->contract_partner_type);

                        return [
                            'id'                            => $i->id,
                            'created_at'                    => DataHelper::getPrettyDateTime($i->created_at),
                            'value'                         => $i->distributed_value,
                            'value_formatted'               => DataHelper::getFloat2Currency($i->distributed_value),
                            'cost_type_text'                => $cost_type['description'],
                            'contract_partner_type_text'    => $contract_partner_type['description'],
                            'partner_text'                  => ($partner == NULL) ? "NÃO DEFINIDO" : $partner,
                        ];
                    })
                ];
            }

//            return $data;
        } else {
	        $data = [];
        }

        $this->page->response = $data;
		$this->page->title      = 'Custo por Nota Fiscal';
		$this->page->subtitle   = 'Custo por Nota Fiscal';

		return view('pages.reports.nf' )
			->with( 'Page', $this->page );
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return View
	 */

	public function cost(Request $request) {
	    if($request->has('search')){

            $CostTypes = CostTypes::all();
            $ContractPartnerTypes = ContractPartnerTypes::all();
            $Vehicles = Vehicle::all();
            $Conveyors = Conveyor::all();

            $query = DB::table('contract_items')
                ->join('moviments', 'moviments.id','contract_items.moviment_id')
                ->join('contracts', 'contracts.id','contract_items.contract_id')
                ->join('invoices', 'invoices.moviment_id','moviments.id');

            if($request->has('cost_type') && $request->get('cost_type') != ""){
                $query = $query->where('contracts.cost_type',$request->get('cost_type'));
            }

            if($request->has('payer_id') && $request->get('payer_id') != ""){
                $query = $query->where('moviments.payer_id' ,$request->get('payer_id'));
            }

            if($request->has('start_at') && ($request->get('start_at') != '')){
                $value = DataHelper::setDate($request->get('start_at'));
                $query = $query->where('moviments.emitted_at','>=', $value);
            }

            if($request->has('end_at') && ($request->get('end_at') != '')){
                $value = DataHelper::setDate($request->get('end_at'));
                $query = $query->where('moviments.emitted_at','<=', $value);
            }



            if($request->has('contract_partner_type') && ($request->get('contract_partner_type') != '')){
                $query = $query->where('contracts.contract_partner_type',$request->get('contract_partner_type'));
                if($request->get('contract_partner_type')==1){ //VEÍCULO
                    $field = 'vehicle_id';
                } else {
                    $field = 'conveyor_id';
                }
                $query = $query->where($field, $request->get('partner_id'));
            }

            $gp = $query->get([
                    'moviments.cte_number',
                    'moviments.freight_icms',
                    'contract_items.id',
                    'contract_items.moviment_id',
                    'contract_items.contract_id',
                    'contract_items.pondered_value',

                    'contracts.cost_type',
                    'contracts.contract_partner_type',
                    'contracts.vehicle_id',
                    'contracts.conveyor_id',
                    'contracts.created_at',
//                    'contract_items.distributed_value'
                ])->groupBy('cte_number');

            $data = [];
            foreach($gp as $key => $g){
                $income     = $g->first()->freight_icms;
                $cost       = $g->sum('pondered_value');
                $result     = ($income - $cost);
                $percent    = round(($result / $income ) * 100, 2);

//                $distributed_value = $g->sum('distributed_value');

                $data[] = [
                    'text'                  => $key,
                    'moviment_id'           => $g->first()->moviment_id,

                    'income'                => $income,
                    'income_formatted'      => DataHelper::getFloat2Currency($income),

                    'cost'                  => $cost,
                    'cost_formatted'        => DataHelper::getFloat2Currency($cost),

                    'result'                => $result,
                    'result_formatted'      => DataHelper::getFloat2Currency($result),

                    'percent'               => $percent,
                    'percent_formatted'     => DataHelper::getFloat2Percent($percent),

                    'items'                 => $g->map(function ($i) use ($CostTypes, $ContractPartnerTypes, $Vehicles, $Conveyors){
                        if($i->contract_partner_type == 1){
                            $partner = optional($Vehicles->find($i->vehicle_id))->getName();
                        } else if($i->contract_partner_type == 2){
                            $partner = optional($Conveyors->find($i->conveyor_id))->getName();
                        }

                        $cost_type = $CostTypes->firstWhere('id', $i->cost_type);
                        $contract_partner_type = $ContractPartnerTypes->firstWhere('id', $i->contract_partner_type);

                        return [
                            'id'                            => $i->id,
                            'created_at'                    => DataHelper::getPrettyDateTime($i->created_at),
                            'value'                         => $i->pondered_value,
                            'value_formatted'               => DataHelper::getFloat2Currency($i->pondered_value),
                            'cost_type_text'                => $cost_type['description'],
                            'contract_partner_type_text'    => $contract_partner_type['description'],
                            'partner_text'                  => ($partner == NULL) ? "NÃO DEFINIDO" : $partner,
                        ];
                    })
                ];
            }
//            return $data;

        } else {
	        $data = [];
        }

        $this->page->response = $data;
        $this->page->auxiliar = [
            'cost_types'            => CostTypes::getAlltoSelectList(),
            'contract_partner_types'=> ContractPartnerTypes::getAlltoSelectList(),
            'payers'                => Entity::getAlltoSelectList(),
        ];
		$this->page->title      = 'Consulta de Custos';
		$this->page->subtitle   = 'Consulta de Custos';

		return view('pages.reports.cost' )
			->with( 'Page', $this->page );
	}

}
