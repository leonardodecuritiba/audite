<?php

namespace App\Observers\Moviments;

use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\Moviments\Conveyor;
use Illuminate\Http\Request;

class ConveyorObserver {

	protected $request;
	protected $table = 'conveyors';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\Moviments\Conveyor $conveyor
	 *
	 * @return void
	 */
	public function creating( Conveyor $conveyor ) {
		//CRIAR UM ADDRESS
		//CRIAR UM CONTACT
		$contact                    = Contact::create( $this->request->all() );
		$address                    = Address::create( $this->request->all() );
		$conveyor->contact_id       = $contact->id;
		$conveyor->address_id       = $address->id;
	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\Moviments\Conveyor $conveyor
	 *
	 * @return void
	 */
	public function saving( Conveyor $conveyor ) {
        if ( $conveyor->address != null ) {
            $conveyor->address->update( $this->request->all() );
            $conveyor->contact->update( $this->request->all() );
        }

        if($conveyor->getAttribute('type')){
            $conveyor->cpf = NULL;
        } else {
            $conveyor->cnpj = NULL;
        }

    }
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\Moviments\Conveyor $conveyor
	 *
	 * @return void
	 */
	public function deleting( Conveyor $conveyor ) {
        $conveyor->address->delete();
        $conveyor->contact->delete();
        $conveyor->price_range_as->each(function($p){
            $p->delete();
        });
        $conveyor->price_range_bs->each(function($p){
            $p->delete();
        });
        $conveyor->price_range_cs->each(function($p){
            $p->delete();
        });
        $conveyor->price_range_ds->each(function($p){
            $p->delete();
        });
        $conveyor->price_range_es->each(function($p){
            $p->delete();
        });
        $conveyor->generalities->each(function($p){
            $p->delete();
        });
	}
}
