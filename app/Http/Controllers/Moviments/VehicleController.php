<?php

namespace App\Http\Controllers\Moviments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\VehicleRequest;
use App\Models\Commons\CepStates;
use App\Models\Moviments\Settings\BodyworkTypes;
use App\Models\Moviments\Settings\ContractTypes;
use App\Models\Moviments\Settings\VehicleTypes;
use App\Models\Moviments\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class VehicleController extends Controller {

	public $entity = "vehicles";
	public $sex = "M";
	public $name = "Veículo";
	public $names = "Veículos";
	public $main_folder = 'pages.moviments.vehicles';
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
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request) {
		$data = Vehicle::get()->map( function ( $s ) {
			return [
				'id'                        => $s->id,
				'plate'                     => $s->getShortName(),
				'name'                      => $s->plate,
				'owner_name'                => $s->owner_name,
				'owner_document_formatted'  => $s->owner_document_formatted,

				'driver_name'               => $s->driver_name,
				'driver_document_formatted' => $s->driver_document_formatted,

				'created_at'            => $s->created_at_formatted,
				'created_at_time'       => $s->created_at_time,
			];
		} );;
		$this->page->response = $data;

		$this->page->create_option = 1;
		return view('pages.moviments.vehicles.index' )
			->with( 'Page', $this->page );
	}

	/**
	 * Create the specified resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create( ) {
		$this->page->auxiliar = [
			'contract_types'    => ContractTypes::getAlltoSelectList(),
			'vehicle_types'     => VehicleTypes::getAlltoSelectList(),
			'bodywork_types'    => BodyworkTypes::getAlltoSelectList(),
		];
		return view('pages.moviments.vehicles.master' )
			->with( 'Page', $this->page );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$this->page->auxiliar = [
			'contract_types'    => ContractTypes::getAlltoSelectList(),
			'vehicle_types'     => VehicleTypes::getAlltoSelectList(),
			'bodywork_types'    => BodyworkTypes::getAlltoSelectList(),
		];
		$data = Vehicle::findOrFail( $id );
		$this->page->create_option = 1;
		return view('pages.moviments.vehicles.master' )
			->with( 'Page', $this->page )
			->with( 'Data', $data );
	}
	/**
	 * Store the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Moviments\VehicleRequest $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( VehicleRequest $request ) {
		$data = Vehicle::create( $request->all() );
		return $this->redirect( 'STORE', $data );
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Moviments\VehicleRequest $request
	 * @param  $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( VehicleRequest $request, $id ) {
		$data = Vehicle::findOrFail( $id );
		$data->update( $request->all() );

		return $this->redirect( 'UPDATE', $data );
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( $id ) {
        $vechicle = Vehicle::find($id);
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $vechicle->getShortName() );
		return new JsonResponse( [
			'status'  => $vechicle->delete(),
			'message' => $message,
		], 200 );
	}
}
