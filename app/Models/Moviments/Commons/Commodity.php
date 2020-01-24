<?php

namespace App\Models\Moviments\Commons;

use App\Models\Moviments\Moviment;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commodity extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	public $timestamps = true;
	protected $fillable = [
		'code',
		'description',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function getName()
	{
		return $this->getAttribute('code') . '-' . $this->getAttribute('description');
	}

	public function getContent()
	{
		return $this->getAttribute('description');
	}

	static public function findData($text){
		$code = substr($text,0,strpos($text,'-'));
		return self::whereCode($code)->first();
	}

	static public function import($text){

		$code = (substr($text,0,strpos($text,'-')));
		$description = substr($text,strpos($text,'-')+1, strlen($text));
		return self::create(
			[
				'code'          => $code,
				'description'   => $description,
			]
		);

//		$m = self::whereDescription($description)->first();
//		if($m == NULL){}
//		return $m;
	}

	/**
	 * Scope a query to only include active.
	 *
	 * @param Builder $query
	 * @return Builder
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
		return $this->hasMany(Moviment::class, 'commodity_id');
	}

	// ******************** RELASHIONSHIP ******************************
	// ********************** BELONGS ********************************
	// ************************** HASMANY **********************************
}
