<?php

namespace App\Models\Moviments;

use App\Helpers\DataHelper;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractItem extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	public $timestamps = true;

	protected $fillable = [
		'moviment_id',
		'contract_id',
		'pondered_value',
		'distributed_value',
	];

	protected $appends = [
		'pondered_value_formatted',
		'distributed_value_formatted',
	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function getShortName()
	{
		return $this->moviment->getShortName();
	}

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

	public function getPonderedValueFormattedAttribute()
	{
		return DataHelper::getFloat2Currency($this->getAttribute('pondered_value'));
	}

	public function getDistributedValueFormattedAttribute()
	{
		return DataHelper::getFloat2Currency($this->getAttribute('distributed_value'));
	}
	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

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
	public function moviment()
	{
		return $this->belongsTo(Moviment::class, 'moviment_id');
	}

	public function contract()
	{
		return $this->belongsTo(Contract::class, 'contract_id');
	}
	//============================================================
	//======================== HASONE ============================
	//============================================================

	//============================================================
	//======================== HASMANY ===========================
	//============================================================

}
