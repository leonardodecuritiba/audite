<?php

namespace App\Traits\Moviments;

use App\Models\Moviments\Contract;
use Illuminate\Support\Facades\DB;

trait MovimentPoliciesTrait {

	public function hasOppenedContracts()
	{
		return DB::table('contracts')
		  ->join('contract_items','contract_items.contract_id','contracts.id')
		  ->where('contract_items.moviment_id', $this->id)
		  ->where('contracts.status', Contract::$_STATUS_CLOSED_)
		  ->count() > 0;
	}

}
