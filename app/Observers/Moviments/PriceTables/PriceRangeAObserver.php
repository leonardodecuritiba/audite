<?php

namespace App\Observers\Moviments\PriceTables;

use App\Models\Moviments\PriceTables\PriceRangeA;
use Illuminate\Http\Request;

class PriceRangeAObserver {

	protected $request;
	protected $table = 'price_range_a_s';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeA $price_range_a
	 *
	 * @return void
	 */
	public function creating( PriceRangeA $price_range_a ) {

	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeA $price_range_a
	 *
	 * @return void
	 */
	public function saving( PriceRangeA $price_range_a ) {
    }
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeA $price_range_a
	 *
	 * @return void
	 */
	public function deleting( PriceRangeA $price_range_a ) {

	}
}
