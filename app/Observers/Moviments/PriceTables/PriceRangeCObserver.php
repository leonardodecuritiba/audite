<?php

namespace App\Observers\Moviments\PriceTables;

use App\Models\Moviments\PriceTables\PriceRangeC;
use Illuminate\Http\Request;

class PriceRangeCObserver {

	protected $request;
	protected $table = 'price_range_c_s';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeC $price_range_c
	 *
	 * @return void
	 */
	public function creating( PriceRangeC $price_range_c ) {

	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeC $price_range_c
	 *
	 * @return void
	 */
	public function saving( PriceRangeC $price_range_c ) {
    }
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeC $price_range_c
	 *
	 * @return void
	 */
	public function deleting( PriceRangeC $price_range_c ) {

	}
}
