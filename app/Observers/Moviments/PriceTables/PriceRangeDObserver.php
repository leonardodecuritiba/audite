<?php

namespace App\Observers\Moviments\PriceTables;

use App\Models\Moviments\PriceTables\PriceRangeD;
use Illuminate\Http\Request;

class PriceRangeDObserver {

	protected $request;
	protected $table = 'price_range_a_s';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeD $price_range_d
	 *
	 * @return void
	 */
	public function creating( PriceRangeD $price_range_d ) {

	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeD $price_range_d
	 *
	 * @return void
	 */
	public function saving( PriceRangeD $price_range_d ) {
    }
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeD $price_range_d
	 *
	 * @return void
	 */
	public function deleting( PriceRangeD $price_range_d ) {

	}
}
