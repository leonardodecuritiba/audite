<?php

namespace App\Traits\Contracts;

use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\EntrustFacade;

trait ContractPoliciesTrait {

	public function canShowEditBtn()
	{
		$u = EntrustFacade::hasRole(['admin', 'root']);
		return ($u && !$this->isClosed());
	}

	public function canShowCloseBtn()
	{
		$u = EntrustFacade::hasRole(['admin', 'root']);
		return ($u && !$this->isClosed());
	}

	public function canShowCancelBtn()
	{
		$u = EntrustFacade::hasRole(['admin', 'root']);
		return ($u && $this->getAttribute('status') != ContractStatusTrait::$_STATUS_CANCELED_);
	}

	public function canShowDeleteBtn()
	{
		$u = EntrustFacade::hasRole(['admin', 'root']);
		return ($u && (
				$this->isClosed()) ||
		        ($this->getAttribute('status') == ContractStatusTrait::$_STATUS_OPENNED_)
		);
	}

	//==================================================================

	public function canShowAddItemBtn()
	{
		$u = EntrustFacade::hasRole(['admin', 'root']);
		return ($u && $this->getAttribute('status') == ContractStatusTrait::$_STATUS_OPENNED_);
	}

	public function canShowDeleteItemBtn()
	{
		$u = EntrustFacade::hasRole(['admin', 'root']);
		return ($u && $this->getAttribute('status') == ContractStatusTrait::$_STATUS_OPENNED_);
	}

}
