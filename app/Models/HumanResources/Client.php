<?php

namespace App\Models\HumanResources;

use App\Helpers\DataHelper;
use App\Models\HumanResources\Settings\Address;
use App\Models\HumanResources\Settings\Contact;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
	use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
	public $timestamps = true;
	static public $img_path = 'clients';

	protected $fillable = [
		'address_id',
		'contact_id',

        'type',

        'name',
		'social_reason',
		'fantasy_name',
        'cpf',
        'cnpj',

        'observations',
		'active',
	];

	protected $appends = [
		'cpf_formatted',
		'cnpj_formatted',
		'short_description',
		'short_document'
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================


	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

    public function getShortName()
    {
        if($this->isLegalPerson()){
            return $this->getAttribute('name');
        }
        return ($this->getAttribute('fantasy_name') != NULL) ? $this->getAttribute('fantasy_name') : $this->getAttribute('social_reason');
    }

    public function getName()
    {
	    return $this->getShortName();
    }

    public function isLegalPerson()
    {
	    return $this->getAttribute('type') == 0;
    }

	public function getShortDescriptionAttribute()
	{
        return $this->getShortName();
	}

	public function getShortDocumentAttribute()
	{
        return ($this->isLegalPerson()) ? $this->cpf_formatted : $this->cnpj_formatted;
	}

	public function getCpfFormattedAttribute()
	{
		return DataHelper::mask($this->getAttribute('cpf'), '###.###.###-##');
	}

    public function getCnpjFormattedAttribute()
    {
        return DataHelper::mask($this->getAttribute('cnpj'), '##.###.###/####-##' );
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



}
