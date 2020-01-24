<?php

namespace App\Http\Controllers\Moviments;

use App\Filters\ContractFilter;
use App\Filters\MovimentFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\ContractRequest;
use App\Models\Commons\CepStates;
use App\Models\Moviments\Contract;
use App\Models\Moviments\Moviment;
use App\Models\Moviments\Settings\ContractPartnerTypes;
use App\Models\Moviments\Settings\CostTypes;
use App\Traits\Contracts\ContractStatusTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\View;

class ContractController extends Controller {

	public $entity = "contracts";
	public $sex = "M";
	public $name = "Contrato";
	public $names = "Contratos";
	public $main_folder = 'pages.moviments.contracts';
	public $page = [];
	public $ContractFilter;

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
		$this->ContractFilter = new ContractFilter();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return View
	 */

	public function index(Request $request) {

		$contracts = new Contract();
		$this->page->response = $this->ContractFilter->map($request, $contracts);

		$this->page->auxiliar = [
			'status'                => ContractStatusTrait::getAllStatustoSelectList(),
			'cost_types'            => CostTypes::getAlltoSelectList(),
			'contract_partner_types'=> ContractPartnerTypes::getAlltoSelectList(),
		];
		$this->page->create_option = 1;
		return view('pages.moviments.contracts.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Create the specified resource.
	 *
	 *
	 * @return View
	 */
	public function create( ) {
		$this->page->auxiliar = [
			'cost_types'            => CostTypes::getAlltoSelectList(),
			'contract_partner_types'=> ContractPartnerTypes::getAlltoSelectList(),
		];
		return view('pages.moviments.contracts.master' )
			->with( 'Page', $this->page );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  $id
	 *
	 * @return View
	 */
	public function edit( $id ) {
        $data = Contract::findOrFail( $id );
        $n_ids = $data->items->pluck('moviment_id');
		$this->page->auxiliar = [
			'cost_types'            => CostTypes::getAlltoSelectList(),
			'contract_partner_types'=> ContractPartnerTypes::getAlltoSelectList(),
			'moviments'             => Moviment::whereNotIn('id', $n_ids)->get()->map( function ( $s ) {
                return [
                    'id'          => $s->id,
                    'description' => $s->getName()
                ];
            } )->pluck( 'description', 'id' ),
			'states'                => CepStates::getAlltoSelectList(),
		];

		$this->page->create_option = 1;
		return view('pages.moviments.contracts.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}
	/**
	 * Store the specified resource in storage.
	 *
	 * @param  ContractRequest $request
	 *
	 * @return View
	 */
	public function store( ContractRequest $request ) {
		$data = Contract::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  ContractRequest $request
	 * @param  $id
	 *
	 * @return View
	 */
	public function update( ContractRequest $request, $id ) {
		$data = Contract::findOrFail( $id );
		if($data->canShowEditBtn()){
			$data->update( $request->all() );
		} else {
			return $this->error( "Esta contratação já foi finalizada! Impossível continuar." );
		}
		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  $id
	 *
	 * @return View
	 */
	public function close( $id ) {
		$data = Contract::findOrFail( $id );
		if(!$data->canShowCloseBtn()){
			return $this->error( "Esta contratação já foi finalizada! Impossível continuar." );
		}
		$data->close();

		return $this->redirect( 'UPDATE', $data );
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  $id
	 *
	 * @return View
	 */
	public function cancel( $id ) {
		$data = Contract::findOrFail( $id );
		if(!$data->canShowCancelBtn()){
			return $this->error( "Esta contratação já foi finalizada! Impossível continuar." );
		}
		$data->cancel();

		return $this->redirect( 'UPDATE', $data );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  $id
	 *
	 * @return JsonResponse
	 */
	public function destroy( $id ) {
		$contract = Contract::find($id);
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $contract->getShortName() );
		return new JsonResponse( [
			'status'  => $contract->delete(),
			'message' => $message,
		], 200 );
	}
}
