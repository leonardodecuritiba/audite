<?php

namespace App\Models\Moviments\Commons;

use App\Models\Moviments\Moviment;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	public $timestamps = true;
	protected $fillable = [
		'moviment_id',
		'serie',
		'number',
	];

	protected $appends = [
		'description_text',
		'created_at_time',
		'created_at_formatted',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function getDescriptionTextAttribute()
	{
		return $this->getAttribute('serie') .'/' . $this->getAttribute('number');
	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	public function moviment()
	{
		return $this->belongsTo(Moviment::class, 'moviment_id');
	}

	// ******************** RELASHIONSHIP ******************************
	// ********************** BELONGS ********************************
	// ************************** HASMANY **********************************
}
