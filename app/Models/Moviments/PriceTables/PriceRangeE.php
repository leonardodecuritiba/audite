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

class PriceRangeE extends Model
{
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
    public $timestamps = true;

    protected $fillable = [
        'conveyor_id',
        'city_id',
        'value_d',
        'excess_d',

        'value_c',
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

	public function getDestroyRoute()
	{
		return route('conveyors.price-range.destroy-city', [$this->getAttribute('id'), 'E']);
	}


    //============================================================
    //======================== ACCESSORS =========================
    //============================================================

	public function getNameAttribute()
	{
		return $this->getShortName();
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
        $value = '(Mínimo) ' . DataHelper::getFloat2Currency($this->getAttribute('value_d'));
        $excess = '(+%NF) ' . DataHelper::getFloat2Percent($this->getAttribute('excess_d'));
        return $value . '; ' .
            $excess;
    }

    public function getShortDescriptionCollectAttribute()
    {
        $value = '(Mínimo) ' . DataHelper::getFloat2Currency($this->getAttribute('value_c'));
        $excess = '(+%NF) ' . DataHelper::getFloat2Percent($this->getAttribute('excess_c'));
        return $value . '; ' .
            $excess;
    }


    //============================================================
    //======================== MUTATORS ==========================
    //============================================================
    public function setValueDAttribute( $value )
    {
        return $this->attributes['value_d'] = DataHelper::getReal2Float( $value );
    }

    public function setExcessDAttribute( $value )
    {
        return $this->attributes['excess_d'] = DataHelper::getReal2Float( $value );
    }

    public function setValueCAttribute( $value )
    {
        return $this->attributes['value_c'] = DataHelper::getReal2Float( $value );
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
