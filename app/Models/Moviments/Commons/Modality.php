<?php

namespace App\Models\Moviments\Commons;

use App\Models\Moviments\Moviment;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modality extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	public $timestamps = true;
	protected $fillable = [
		'description',
	];


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

	/**
	 * Scope a query to only include active.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeActive($query)
	{
		return $query;
	}
	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================

	public function moviments()
	{
		return $this->hasMany(Moviment::class, 'modality_id');
	}

	// ******************** RELASHIONSHIP ******************************
	// ********************** BELONGS ********************************
	// ************************** HASMANY **********************************
}
