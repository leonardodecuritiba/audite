<?php

namespace App\Observers\Moviments\PriceTables;

use App\Models\Moviments\PriceTables\PriceRangeB;
use Illuminate\Http\Request;

class PriceRangeBObserver {

	protected $request;
	protected $table = 'price_range_b_s';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeB $price_range_b
	 *
	 * @return void
	 */
	public function creating( PriceRangeB $price_range_b ) {

	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeB $price_range_b
	 *
	 * @return void
	 */
	public function saving( PriceRangeB $price_range_b ) {
    }
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\Moviments\PriceTables\PriceRangeB $price_range_b
	 *
	 * @return void
	 */
	public function deleting( PriceRangeB $price_range_b ) {
	}
}
