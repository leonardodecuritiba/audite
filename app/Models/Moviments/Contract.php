<?php

namespace App\Models\Moviments;

use App\Helpers\DataHelper;
use App\Models\Commons\Logs;
use App\Models\Moviments\Settings\ContractPartnerTypes;
use App\Models\Moviments\Settings\CostTypes;
use App\Traits\Contracts\ContractFlowTrait;
use App\Traits\Contracts\ContractPoliciesTrait;
use App\Traits\Contracts\ContractStatusTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use ContractPoliciesTrait;
	use ContractStatusTrait;
	use ContractFlowTrait;
	public $timestamps = true;

	protected $fillable = [
		'cost_type',
		'contract_partner_type',
		'vehicle_id',
		'conveyor_id',

		'contracted_at',
		'realized_at',

		'description',
		'value',
		'payment_form',
		'payment_date',
		'status',
	];

	protected $appends = [
		'value_formatted',
		'value_currency',
		'status_array',

		'cost_type_text',
		'contract_partner_type_text',

		'payment_date_formatted',
		'partner_id',
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================


	//============================================================
	//======================== ACCESSORS =========================
	//============================================================
	public function canEdit()
	{
		return $this->getAttribute('description');
	}

	public function getShortName()
	{
		return $this->getAttribute('description');
	}

	public function getName()
	{
		return $this->getAttribute('description');
	}

	public function getValueFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('value'));
	}

	public function getValueCurrencyAttribute()
	{
		return DataHelper::getFloat2Currency($this->getAttribute('value'));
	}

	public function getCostTypeTextAttribute()
	{
		return CostTypes::whereId($this->getAttribute('cost_type'))->description;
	}

	public function getPartnerIdAttribute()
	{
		$field = ($this->getAttribute('contract_partner_type') == 1) ? 'vehicle_id' : 'conveyor_id';
		return $this->getAttribute($field);
	}

	public function getPaymentDateFormattedAttribute()
	{
		return DataHelper::getPrettyDate($this->getAttribute('payment_date'));
	}

	public function getContractPartnerTypeTextAttribute()
	{
		return ContractPartnerTypes::whereId($this->getAttribute('contract_partner_type'))->description;
	}


	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

	public function setValueAttribute( $value )
	{
		return $this->attributes['value'] = DataHelper::getReal2Float( $value );
	}


	public function setContractedAtAttribute( $value )
	{
		return $this->attributes['contracted_at'] = DataHelper::setDate( $value );
	}

	public function setRealizedAtAttribute( $value )
	{
		return $this->attributes['realized_at'] = DataHelper::setDate( $value );
	}

	public function setPaymentDateAttribute( $value )
	{
		return $this->attributes['payment_date'] = DataHelper::setDate( $value );
	}

	//============================================================
	//======================== SCOPE =============================
	//============================================================

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	//============================================================
	//======================== BELONGS ===========================
	//============================================================
	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class, 'vehicle_id');
	}

	public function conveyor()
	{
		return $this->belongsTo(Conveyor::class, 'conveyor_id');
	}

	//============================================================
	//======================== HASONE ============================
	//============================================================

	//============================================================
	//======================== HASMANY ===========================
	//============================================================

	public function items()
	{
		return $this->hasMany(ContractItem::class, 'contract_id');
	}
	public function logs()
	{
		return $this->hasMany(Logs::class, 'pk')->where('table', $this->table);
	}

}
