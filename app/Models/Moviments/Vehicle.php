<?php

namespace App\Models\Moviments;

use App\Helpers\DataHelper;
use App\Traits\ActiveTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;
    use DateTimeTrait;
    use StringTrait;
    use ActiveTrait;
    public $timestamps = true;

    protected $fillable = [
        'plate',
        'contract_type',

        'vehicle_type',
        'bodywork_type',
        'capacity',

        'owner_type',
        'owner_name',
        'owner_cpf',
        'owner_cnpj',

        'driver_type',
        'driver_name',
        'driver_cpf',
        'driver_cnpj',

        'brand',
        'model',
        'active',
    ];

    protected $appends = [

        'plate_formatted',

        'owner_cpf_formatted',
        'owner_cnpj_formatted',
        'owner_document_formatted',

        'driver_cpf_formatted',
        'driver_cnpj_formatted',
        'driver_document_formatted',

        'short_description',
    ];


    //============================================================
    //======================== FUNCTIONS =========================
    //============================================================

    static public function getOrCreate( $plate )
    {
        $v = NULL;
        if($plate != NULL){
            $v = self::where('plate', $plate )->first();
            if($v == NULL){
                $v = self::create([
                    'plate' => $plate
                ]);
            }
        }
        return $v;
    }

    //============================================================
    //======================== ACCESSORS =========================
    //============================================================

    public function getShortName()
    {
        return $this->plate_formatted;
    }

    public function getName()
    {
        return $this->plate_formatted;
    }

    public function isOwnerLegalPerson()
    {
        return $this->getAttribute('owner_type') == 0;
    }

    public function getShortDescriptionAttribute()
    {
        return $this->plate_formatted;
    }


    public function getPlateFormattedAttribute()
    {
        return DataHelper::mask($this->getAttribute('plate'), '###-####');
    }

    public function getOwnerDocumentFormattedAttribute()
    {
        return $this->isOwnerLegalPerson() ? $this->owner_cpf_formatted : $this->owner_cnpj_formatted;
    }

    public function getOwnerCpfFormattedAttribute()
    {
        return DataHelper::mask($this->getAttribute('owner_cpf'), '###.###.###-##');
    }

    public function getOwnerCnpjFormattedAttribute()
    {
        return DataHelper::mask($this->getAttribute('owner_cnpj'), '##.###.###/####-##' );
    }

    public function isDriverLegalPerson()
    {
        return $this->getAttribute('driver_type') == 0;
    }

    public function getDriverDocumentFormattedAttribute()
    {
        return $this->isDriverLegalPerson() ? $this->driver_cpf_formatted : $this->driver_cnpj_formatted;
    }

    public function getDriverCpfFormattedAttribute()
    {
        return DataHelper::mask($this->getAttribute('driver_cpf'), '###.###.###-##');
    }

    public function getDriverCnpjFormattedAttribute()
    {
        return DataHelper::mask($this->getAttribute('driver_cnpj'), '##.###.###/####-##' );
    }


    //============================================================
    //======================== MUTATORS ==========================
    //============================================================

    public function setOwnerCnpjAttribute( $value )
    {
        return $this->attributes['owner_cnpj'] = DataHelper::getOnlyNumbers( $value );
    }

    public function setOwnerCpfAttribute( $value )
    {
        return $this->attributes['owner_cpf'] = DataHelper::getOnlyNumbers( $value );
    }

    public function setDriverCnpjAttribute( $value )
    {
        return $this->attributes['driver_cnpj'] = DataHelper::getOnlyNumbers( $value );
    }

    public function setDriverCpfAttribute( $value )
    {
        return $this->attributes['driver_cpf'] = DataHelper::getOnlyNumbers( $value );
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

    //============================================================
    //======================== HASONE ============================
    //============================================================

    //============================================================
    //======================== HASMANY ===========================
    //============================================================
	public function contracts()
	{
		return $this->belongsTo(Contract::class, 'vehicle_id');
	}



}
