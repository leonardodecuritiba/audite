<?php

namespace App\Models\Moviments\PriceTables;

use App\Helpers\DataHelper;
use App\Models\Commons\CepCities;
use App\Models\Moviments\Conveyor;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceRangeA extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use ActiveTrait;
	public $timestamps = true;

	protected $fillable = [
		'conveyor_id',
		'city_id',
		'value_a_d',
		'value_b_d',
		'value_c_d',
		'value_d_d',
		'value_e_d',
		'value_f_d',
		'excess_d',

		'value_a_c',
		'value_b_c',
		'value_c_c',
		'value_d_c',
		'value_e_c',
		'value_f_c',
		'excess_c',
	];

	protected $appends = [
		'name',
		'city_formatted',
		'short_description_delivery',
		'short_description_collect',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================


	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

	public function getNameAttribute()
	{
		return $this->getShortName();
	}

	public function getDestroyRoute()
	{
		return route('conveyors.price-range.destroy-city',[$this->getAttribute('id'), 'A']);
	}

	public function getShortName()
	{
		return $this->getAttribute('description');
	}

	public function getCityFormattedAttribute()
	{
		return $this->city->getShortNameState();
	}

	public function getShortDescriptionDeliveryAttribute()
	{
		$value_a = '(10kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_a_d'));
		$value_b = '(20kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_b_d'));
		$value_c = '(30kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_c_d'));
		$value_d = '(50kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_d_d'));
		$value_e = '(70kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_e_d'));
		$value_f = '(100kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_f_d'));
		$excess = '(+) ' . DataHelper::getFloat2Currency($this->getAttribute('excess_d'));
		return $value_a . '; ' .
		       $value_b . '; ' .
		       $value_c . '; ' .
		       $value_d . '; ' .
		       $value_e . '; ' .
		       $value_f . '; ' .
		       $excess;
	}

	public function getShortDescriptionCollectAttribute()
	{
		$value_a = '(10kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_a_c'));
		$value_b = '(20kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_b_c'));
		$value_c = '(30kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_c_c'));
		$value_d = '(50kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_d_c'));
		$value_e = '(70kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_e_c'));
		$value_f = '(100kg) ' . DataHelper::getFloat2Currency($this->getAttribute('value_f_c'));
		$excess = '(+) ' . DataHelper::getFloat2Currency($this->getAttribute('excess_c'));
		return $value_a . '; ' .
		       $value_b . '; ' .
		       $value_c . '; ' .
		       $value_d . '; ' .
		       $value_e . '; ' .
		       $value_f . '; ' .
		       $excess;
	}


	//============================================================
	//======================== MUTATORS ==========================
	//============================================================
    public function setValueADAttribute( $value )
    {
        return $this->attributes['value_a_d'] = DataHelper::getReal2Float( $value );
    }
    public function setValueBDAttribute( $value )
    {
        return $this->attributes['value_b_d'] = DataHelper::getReal2Float( $value );
    }
    public function setValueCDAttribute( $value )
    {
        return $this->attributes['value_c_d'] = DataHelper::getReal2Float( $value );
    }
    public function setValueDDAttribute( $value )
    {
        return $this->attributes['value_d_d'] = DataHelper::getReal2Float( $value );
    }
    public function setValueEDAttribute( $value )
    {
        return $this->attributes['value_e_d'] = DataHelper::getReal2Float( $value );
    }
    public function setValueFDAttribute( $value )
    {
        return $this->attributes['value_f_d'] = DataHelper::getReal2Float( $value );
    }
    public function setExcessDAttribute( $value )
    {
        return $this->attributes['excess_d'] = DataHelper::getReal2Float( $value );
    }

    public function setValueACAttribute( $value )
    {
        return $this->attributes['value_a_c'] = DataHelper::getReal2Float( $value );
    }
    public function setValueBCAttribute( $value )
    {
        return $this->attributes['value_b_c'] = DataHelper::getReal2Float( $value );
    }
    public function setValueCCAttribute( $value )
    {
        return $this->attributes['value_c_c'] = DataHelper::getReal2Float( $value );
    }
    public function setValueDCAttribute( $value )
    {
        return $this->attributes['value_d_c'] = DataHelper::getReal2Float( $value );
    }
    public function setValueECAttribute( $value )
    {
        return $this->attributes['value_e_c'] = DataHelper::getReal2Float( $value );
    }
    public function setValueFCAttribute( $value )
    {
        return $this->attributes['value_f_c'] = DataHelper::getReal2Float( $value );
    }
    public function setExcessCAttribute( $value )
    {
        return $this->attributes['excess_c'] = DataHelper::getReal2Float( $value );
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
	public function conveyor()
	{
		return $this->belongsTo(Conveyor::class, 'conveyor_id');
	}

	public function city()
	{
		return $this->belongsTo(CepCities::class, 'city_id');
	}

	//============================================================
	//======================== HASONE ============================
	//============================================================

	//============================================================
	//======================== HASMANY ===========================
	//============================================================



}
