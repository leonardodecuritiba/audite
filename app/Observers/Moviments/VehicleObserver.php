<?php

namespace App\Observers\Moviments;

use App\Models\Moviments\Vehicle;
use Illuminate\Http\Request;

class VehicleObserver {

	protected $request;
	protected $table = 'vehicles';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Moviments\Vehicle $vehicle
	 *
	 * @return void
	 */
	public function creating( Vehicle $vehicle ) {
	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Moviments\Vehicle $vehicle
	 *
	 * @return void
	 */
	public function saving( Vehicle $vehicle ) {
	}
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\Moviments\Vehicle $vehicle
	 *
	 * @return void
	 */
	public function deleting( Vehicle $vehicle ) {
	}
}
