<?php

namespace App\Observers\HumanResources;

use App\Models\HumanResources\Settings\Contact;
use App\Models\HumanResources\User;
use App\Models\Users\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserObserver {

	protected $request;
	protected $table = 'users';

	public function __construct( Request $request ) {
		$this->request = $request;
	}
	/**
	 * Listen to the Provider created event.
	 *
	 * @param  \App\Models\HumanResources\User $user
	 *
	 * @return void
	 */
	public function creating( User $user ) {
		$user->password = Hash::make($this->request->get('password'));
	}


	/**
	 * Listen to the Client updating event.
	 *
	 * @param  \App\Models\HumanResources\User $user
	 *
	 * @return void
	 */
	public function saving( User $user ) {
		if(isset($user->id)){
			$role_id = $this->request->get('role_id');
			if($role_id != $user->getRoleId()){
				DB::table('role_user')->where('user_id', $user->id)->update(['role_id' => $role_id]);
			}
		}
	}
	/**
	 * Listen to the Provider deleting event.
	 *
	 * @param  \App\Models\HumanResources\User $user
	 *
	 * @return void
	 */
	public function deleting( User $user ) {
	}
}
