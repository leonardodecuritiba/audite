<?php

namespace App\Observers\Moviments;

use App\Models\Moviments\Moviment;
use App\Models\Moviments\Vehicle;
use Illuminate\Http\Request;

class MovimentObserver {

	protected $request;
	protected $table = 'moviments';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Moviments\Moviment $moviment
	 *
	 * @return void
	 */
	public function creating( Moviment $moviment ) {
	}

	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Moviments\Moviment $moviment
	 *
	 * @return void
	 */
	public function created( Moviment $moviment ) {

	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Moviments\Moviment $moviment
	 *
	 * @return void
	 */
	public function saving( Moviment $moviment ) {
//	    dd($this->request->all());
//        horse
//        cart
//        deliver
        if($this->request->has('horse') && $this->request->get('horse') != "") {
            $horse = Vehicle::getOrCreate($this->request->get('horse'));
            $moviment->horse_id = $horse->id;
        }
        if($this->request->has('cart') && $this->request->get('cart') != "") {
            $cart = Vehicle::getOrCreate($this->request->get('cart'));
            $moviment->cart_id = $cart->id;
        }
        if($this->request->has('deliver') && $this->request->get('deliver') != "") {
            $deliver = Vehicle::getOrCreate($this->request->get('deliver'));
            $moviment->deliver_id = $deliver->id;
        }
	}
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\Moviments\Moviment $moviment
	 *
	 * @return void
	 */
	public function deleting( Moviment $moviment ) {

		$moviment->items->each(function($p){
			$p->delete();
		});
		$moviment->invoices->each(function($p){
			$p->delete();
		});
	}
}
