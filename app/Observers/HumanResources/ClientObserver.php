<?php

namespace App\Observers\HumanResources;

use App\Models\HumanResources\Client;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use Illuminate\Http\Request;

class ClientObserver {

	protected $request;
	protected $table = 'clients';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\HumanResources\Client $client
	 *
	 *
	 * @return void
	 */
	public function creating( Client $client ) {
		//CRIAR UM ADDRESS
		//CRIAR UM CONTACT
		$contact            = Contact::create( $this->request->all() );
		$address            = Address::create( $this->request->all() );
		$client->contact_id = $contact->id;
		$client->address_id = $address->id;
	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\HumanResources\Client $client
	 *
	 * @return void
	 */
	public function saving( Client $client ) {
		if ( $client->address != null ) {
			$client->address->update( $this->request->all() );
			$client->contact->update( $this->request->all() );
		}
	}
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\HumanResources\Client $client
	 *
	 * @return void
	 */
	public function deleting( Client $client ) {
		$client->address->delete();
		$client->contact->delete();
	}
}
