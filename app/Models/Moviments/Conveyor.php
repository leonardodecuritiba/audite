<?php

namespace App\Models\Moviments;

use App\Helpers\DataHelper;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Models\Moviments\PriceTables\PriceRangeA;
use App\Models\Moviments\PriceTables\PriceRangeB;
use App\Models\Moviments\PriceTables\PriceRangeC;
use App\Models\Moviments\PriceTables\PriceRangeD;
use App\Models\Moviments\PriceTables\PriceRangeE;
use App\Models\Moviments\Settings\ConveyorGeneralities;
use App\Models\Moviments\Settings\PriceTypes;
use App\Models\Moviments\Settings\PriorityTypes;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conveyor extends Model
{
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
    public $timestamps = true;

    protected $fillable = [
        'contact_id',
        'address_id',

        'initials',
        'type',
        'cpf',
        'cnpj',
        'ie',
        'social_reason',
        'description',
        'priority_type',
        'price_type',
        'active',
    ];

    protected $appends = [

        'cpf_formatted',
        'cnpj_formatted',
        'document_formatted',

        'short_description',

        'priority_type_formatted',
        'price_type_formatted',

    ];

    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================


    //============================================================
    //======================== ACCESSORS =========================
    //============================================================
    public function getShortName()
    {
        return $this->getAttribute('initials');
    }

    public function getName()
    {
        return $this->getAttribute('initials') . ' - ' . $this->getAttribute('social_reason');
    }

    public function getShortDescriptionAttribute()
    {
        return $this->getName();
    }

    public function isLegalPerson()
    {
        return $this->getAttribute('type') == 0;
    }

    public function getDocumentFormattedAttribute()
    {
        return $this->isLegalPerson() ? $this->cpf_formatted : $this->cnpj_formatted;
    }

    public function getCpfFormattedAttribute()
    {
        return DataHelper::mask($this->getAttribute('cpf'), '###.###.###-##');
    }

    public function getCnpjFormattedAttribute()
    {
        return DataHelper::mask($this->getAttribute('cnpj'), '##.###.###/####-##' );
    }

    public function getPriorityTypeFormattedAttribute()
    {
        return ($this->getAttribute('priority_type')!= NULL) ? PriorityTypes::whereId($this->getAttribute('priority_type'))->description : "";
    }

    public function getPriceTypeFormattedAttribute()
    {
        return ($this->getAttribute('price_type')!= NULL) ? PriceTypes::whereId($this->getAttribute('price_type'))->description : "";
    }


    //============================================================
    //======================== MUTATORS ==========================
    //============================================================

    public function setCnpjAttribute( $value )
    {
        return $this->attributes['cnpj'] = DataHelper::getOnlyNumbers( $value );
    }

    public function setCpfAttribute( $value )
    {
        return $this->attributes['cpf'] = DataHelper::getOnlyNumbers( $value );
    }

    //============================================================
    //======================== SCOPE =============================
    //============================================================

    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================
    public function isType($str)
    {
        switch($str){
            case 'A':
                return $this->attributes['price_type'] == 1;
            case 'B':
                return $this->attributes['price_type'] == 2;
            case 'C':
                return $this->attributes['price_type'] == 3;
            case 'D':
                return $this->attributes['price_type'] == 4;
            case 'E':
                return $this->attributes['price_type'] == 5;
        }
        return $this->getAttribute('initials');
    }

    public function getPriceRange()
    {
        switch($this->attributes['price_type'] ){
            case 1:
                return $this->price_range_as;
            case 2:
                return $this->price_range_bs;
            case 3:
                return $this->price_range_cs;
            case 4:
                return $this->price_range_ds;
            case 5:
                return $this->price_range_es;
        }
    }

    //============================================================
    //======================== RELASHIONSHIP =====================
    //============================================================

    //============================================================
    //======================== BELONGS ===========================
    //============================================================
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    //============================================================
    //======================== HASONE ============================
    //============================================================

    //============================================================
    //======================== HASMANY ===========================
    //============================================================

    public function price_range_as()
    {
        return $this->hasMany(PriceRangeA::class, 'conveyor_id');
    }

    public function price_range_bs()
    {
        return $this->hasMany(PriceRangeB::class, 'conveyor_id');
    }

    public function price_range_cs()
    {
        return $this->hasMany(PriceRangeC::class, 'conveyor_id');
    }

    public function price_range_ds()
    {
        return $this->hasMany(PriceRangeD::class, 'conveyor_id');
    }

    public function price_range_es()
    {
        return $this->hasMany(PriceRangeE::class, 'conveyor_id');
    }

    public function generalities()
    {
        return $this->hasMany(ConveyorGeneralities::class, 'conveyor_id');
    }

	public function moviments()
	{
		return $this->hasMany(Moviment::class, 'partner_id');
	}

	public function contracts()
	{
		return $this->belongsTo(Contract::class, 'conveyor_id');
	}


}
