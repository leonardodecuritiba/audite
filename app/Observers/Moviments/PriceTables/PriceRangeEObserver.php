<?php

namespace App\Observers\Moviments\PriceTables;

use App\Models\Moviments\PriceTables\PriceRangeE;
use Illuminate\Http\Request;

class PriceRangeEObserver {

	protected $request;
	protected $table = 'price_range_e_s';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeE $price_range_e
	 *
	 * @return void
	 */
	public function creating( PriceRangeE $price_range_e ) {

	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeE $price_range_e
	 *
	 * @return void
	 */
	public function saving( PriceRangeE $price_range_e ) {
    }
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeE $price_range_e
	 *
	 * @return void
	 */
	public function deleting( PriceRangeE $price_range_e ) {

	}
}
