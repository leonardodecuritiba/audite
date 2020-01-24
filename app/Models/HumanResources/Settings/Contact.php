<?php

namespace App\Models\HumanResources\Settings;

use App\Helpers\DataHelper;
use App\Models\HumanResources\User;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	public $timestamps = true;
	protected $fillable = [
		'phone',
		'cellphone',
		'skype',
		'email_contact',
	];

	protected $appends = [
		'phone_formatted',
		'cellphone_formatted',
	];

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

	public function getPhoneFormattedAttribute()
	{
		return DataHelper::mask( $this->attributes['phone'], '(##)####-####' );
	}

	public function getCellphoneFormattedAttribute()
	{
		return DataHelper::mask( $this->attributes['cellphone'], '(##)#####-####' );
	}

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

	public function setPhoneAttribute( $value )
	{
		return $this->attributes['phone'] = DataHelper::getOnlyNumbers( $value );
	}

	public function setCellphoneAttribute( $value )
	{
		return $this->attributes['cellphone'] = DataHelper::getOnlyNumbers( $value );
	}

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function getName()
	{
		return $this->getAttribute('description');
	}

	public function getContent()
	{
		return $this->getAttribute('description');
	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================
//	static public function getAlltoSelectList() {
//		return self::get()->map( function ( $s ) {
//			return [
//				'id'          => $s->idmarca,
//				'description' => $s->descricao
//			];
//		} )->pluck( 'description', 'id' );
//	}

	//============================================================
	//======================== HASONE ============================
	//============================================================

}
