<?php

namespace App\Observers\Moviments;

use App\Models\Commons\Logs;
use App\Models\Moviments\Contract;
use Illuminate\Http\Request;

class ContractObserver {

	protected $request;
	protected $table = 'contracts';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param Contract $contract
	 *
	 * @return void
	 */
	public function creating( Contract $contract ) {
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param Contract $contract
	 *
	 * @return void
	 */
	public function created( Contract $contract )
	{
		Logs::onCreate([
			'table' => $this->table,
			'pk'    => $contract->id,
		]);
	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param Contract $contract
	 *
	 * @return void
	 */
	public function saving( Contract $contract ) {

//		dd($this->request->all());
		if($this->request->has('contract_partner_type')){
			$partner_id = $this->request->get('contract_partner_type');
			if($partner_id == 1){
				$contract->vehicle_id =$this->request->get('partner_id');
				$contract->conveyor_id =NULL;
			} else if($partner_id == 2){
				$contract->conveyor_id =$this->request->get('partner_id');
				$contract->vehicle_id =NULL;
			}
		}
//		dd($this->request->all());
    }
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param Contract $contract
	 *
	 * @return void
	 */
	public function deleting( Contract $contract ) {
		$contract->items->each(function($p){
            $p->delete();
        });
	}
}
