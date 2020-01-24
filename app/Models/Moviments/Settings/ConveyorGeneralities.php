<?php

namespace App\Models\Moviments\Settings;

use App\Helpers\DataHelper;
use App\Models\Moviments\Conveyor;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConveyorGeneralities extends Model
{
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    public $timestamps = true;

    protected $fillable = [
        'conveyor_id',
        'type',
        'value',
        'has_min',
        'value_min',
    ];

    protected $appends = [
        'type_text',
        'value_formatted',
        'value_min_formatted',
    ];


    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================


    //============================================================
    //======================== ACCESSORS =========================
    //============================================================

    public function getShortName()
    {
        return $this->type_text;
    }

    public function getTypeTextAttribute( )
    {
        return Generalities::whereId($this->getAttribute('type'))->description;
    }

    public function getValueFormattedAttribute( )
    {
        $o = Generalities::whereId($this->getAttribute('type'));
        return ($o->type == 'percent') ? DataHelper::getFloat2Percent3( $this->attributes['value'] ) : DataHelper::getFloat2Currency( $this->attributes['value'] );

    }

    public function getValueMinFormattedAttribute( )
    {
        return ($this->getAttribute('has_min')) ? ' (mínimo: ' . DataHelper::getFloat2Currency( $this->attributes['value_min'] ) .')': '';

    }

    //============================================================
    //======================== MUTATORS ==========================
    //============================================================
    public function setValueAttribute( $value )
    {
        return $this->attributes['value'] = DataHelper::getReal2Float( $value );
    }
    public function setValueMinAttribute( $value )
    {
        return $this->attributes['value_min'] = DataHelper::getReal2Float( $value );
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

    //============================================================
    //======================== HASONE ============================
    //============================================================

    //============================================================
    //======================== HASMANY ===========================
    //============================================================

}