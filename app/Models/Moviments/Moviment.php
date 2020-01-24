<?php

namespace App\Models\Moviments;

use App\Helpers\DataHelper;
use App\Models\Moviments\Commons\Commodity;
use App\Models\Moviments\Commons\DocumentType;
use App\Models\Moviments\Commons\Entity;
use App\Models\Moviments\Commons\Invoice;
use App\Models\Moviments\Commons\Modality;
use App\Models\Moviments\Commons\Receiver;
use App\Models\Moviments\Commons\Specie;
use App\Models\Moviments\Settings\MovimentFreight;
use App\Traits\DateTimeTrait;
use App\Traits\Moviments\MovimentPoliciesTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moviment extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use MovimentPoliciesTrait;
	use StringTrait;
	public $timestamps = true;

	protected $fillable = [
		'sender_id',
		'dispatcher_id',
		'payer_id',
		'receiver_id',

		'commodity_id',
		'specie_id',
		'modality_id',
		'partner_id',
		'destiny_unity',

		'horse_id',
		'cart_id',
		'deliver_id',

		'ctrc',
		'cte_number',
		'document_type',
		'emitted_at',
		'cte_key',


		'nf_number',
		'real_weight',
		'cubage',
		'volume_quantity',
		'freight',

		'value',
		'calculus_type',
		'calculus_table',
		'freight_value',

		'freight_icms',
		'calculus_basis',
		'icms_value',
		'aliquot',

		'iss_value',
		'weight_calculated',
		'weight_freight',

		'value_freight',
		'despatch',
		'cat',
		'itr',

		'gris',
		'toll',
		'tas',
		'tda',

		'suframa',
		'others',
		'collect',
		'tdc',
		'tde',
		'tar',
		'trt',

		'first_manifest',
		'first_manifested_at',
		'last_manifest',
		'last_manifested_at',
		'last_cargo',
		'last_cargo_at',

		'last_occurrence_code',
		'delivery_prevision',
		'delivered_at',

		'canceled_at',
		'canceled_reason',
		'request_number',
	];

	protected $appends = [
		'emitted_at_formatted',

		'real_weight_formatted',
		'cubage_formatted',
		'value_formatted',
		'freight_text',
		'document_type_text',
		'freight_value_formatted',

        'freight_icms_formatted',
        'calculus_basis_formatted',
        'icms_value_formatted',
        'aliquot_formatted',

        'iss_value_formatted',
        'weight_calculated_formatted',
        'weight_freight_formatted',

        'value_freight_formatted',
        'despatch_formatted',
        'cat_formatted',
        'itr_formatted',

        'gris_formatted',
        'toll_formatted',
        'tas_formatted',
        'tda_formatted',

        'suframa_formatted',
        'others_formatted',
        'collect_formatted',
        'tdc_formatted',
        'tde_formatted',
        'tar_formatted',
        'trt_formatted',

        'first_manifested_at_formatted',
        'last_manifested_at_formatted',
        'last_cargo_at_formatted',

        'delivery_prevision_formatted',
        'delivered_at_formatted',
        'canceled_at_formatted',

	];

	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function getShortName()
	{
		return $this->getName();
	}

	public function getName()
	{
		return $this->id . " - " . $this->getAttribute('cte_number') . " - " . $this->getAttribute('first_manifest');
	}

	static public function _create(array $attributes, $notas)
	{
		$notas = DataHelper::removeAllWhiteSpaces($notas);
		$ns = explode(',',($notas));

		$moviment = self::create($attributes);
		$notas = array();
		if(count($ns) > 1){
			$v = explode('/',$ns[0])[1];
			$attributes['nf_number'] = $v;
			foreach($ns as $n){
				$v = explode('/',$n);
				$notas[] = [
					'moviment_id'   => $moviment->id,
					'serie'         => ($v[0]),
					'number'        => ($v[1]),
				];
			}
			Invoice::insert($notas);
		} else {
			$v = explode('/',$ns[0]);
			$attributes['nf_number'] = ($ns[0]);
			$notas = [
				'moviment_id'   => $moviment->id,
				'serie'         => ($v[0]),
				'number'        => ($v[1]),
			];
			Invoice::create($notas);
		}
		return $moviment;
	}

	public function scopeActive($query)
	{
		return $query;
	}

	//============================================================
	//======================== ACCESSORS =========================
	//============================================================

    public function getEmittedAtFormattedAttribute()
    {
        return DataHelper::getPrettyDateTime($this->getAttribute('emitted_at'));
    }

	public function getFreightTextAttribute()
	{
		return MovimentFreight::whereId($this->getAttribute('freight'))->description;
	}

	public function getDocumentTypeTextAttribute()
	{
		return DocumentType::whereId($this->getAttribute('document_type'))->description;
	}

	public function getRealWeightFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('real_weight'));
	}

	public function getCubageFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('cubage'));
	}

	public function getValueFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('value'));
	}

	public function getFreightValueFormattedAttribute()
	{
		return DataHelper::getFloat2Real($this->getAttribute('freight_value'));
	}


    public function getFreightIcmsFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('freight_icms'));
    }

    public function getCalculusBasisFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('calculus_basis'));
    }

    public function getIcmsValueFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('icms_value'));
    }

    public function getAliquotFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('aliquot'));
    }

    public function getIssValueFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('iss_value'));
    }

    public function getWeightCalculatedFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('weight_calculated'));
    }

    public function getWeightFreightFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('weight_freight'));
    }


    public function getValueFreightFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('value_freight'));
    }

    public function getDespatchFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('despatch'));
    }

    public function getCatFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('cat'));
    }

    public function getItrFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('itr'));
    }


    public function getGrisFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('gris'));
    }

    public function getTollFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('toll'));
    }

    public function getTasFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('tas'));
    }

    public function getTdaFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('tda'));
    }


    public function getSuframaFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('suframa'));
    }

    public function getOthersFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('others'));
    }

    public function getCollectFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('collect'));
    }

    public function getTdcFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('tdc'));
    }

    public function getTdeFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('tde'));
    }

    public function getTarFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('tar'));
    }

    public function getTrtFormattedAttribute()
    {
        return DataHelper::getFloat2Real($this->getAttribute('trt'));
    }


    public function getFirstManifestedAtFormattedAttribute()
    {
        return DataHelper::getPrettyDate($this->getAttribute('first_manifested_at'));
    }

    public function getLastManifestedAtFormattedAttribute()
    {
        return DataHelper::getPrettyDate($this->getAttribute('last_manifested_at'));
    }

    public function getLastCargoAtFormattedAttribute()
    {
        return DataHelper::getPrettyDate($this->getAttribute('last_cargo_at'));
    }


    public function getDeliveryPrevisionFormattedAttribute()
    {
        return DataHelper::getPrettyDate($this->getAttribute('delivery_prevision'));
    }

    public function getDeliveredAtFormattedAttribute()
    {
        return DataHelper::getPrettyDate($this->getAttribute('delivered_at'));
    }

    public function getCanceledAtFormattedAttribute()
    {
        return DataHelper::getPrettyDate($this->getAttribute('canceled_at'));
    }





	public function getInvoicesText()
	{
		$invoices = $this->invoices;
		if($invoices->count() <= 1)
			return $invoices->first()->description_text;

		return implode(", ", $invoices->map(function($i){
			return $i->description_text;
		})->toArray());
	}

	//============================================================
	//======================== MUTATORS ==========================
	//============================================================

    public function setEmittedAtAttribute($value)
    {
        $this->attributes['emitted_at'] = DataHelper::setDateTime($value);
    }

    public function setRealWeightAttribute($value)
    {
        $this->attributes['real_weight'] = DataHelper::getReal2Float($value);
    }

    public function setCubageAttribute($value)
    {
        $this->attributes['cubage'] = DataHelper::getReal2Float($value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = DataHelper::getReal2Float($value);
    }

    public function setFreightValueAttribute($value)
    {
        $this->attributes['freight_value'] = DataHelper::getReal2Float($value);
    }


    public function setFreightIcmsAttribute($value)
    {
        $this->attributes['freight_icms'] = DataHelper::getReal2Float($value);
    }

    public function setCalculusBasisAttribute($value)
    {
        $this->attributes['calculus_basis'] = DataHelper::getReal2Float($value);
    }

    public function setIcmsValueAttribute($value)
    {
        $this->attributes['icms_value'] = DataHelper::getReal2Float($value);
    }

    public function setAliquotAttribute($value)
    {
        $this->attributes['aliquot'] = DataHelper::getReal2Float($value);
    }

    public function setIssValueAttribute($value)
    {
        $this->attributes['iss_value'] = DataHelper::getReal2Float($value);
    }

    public function setWeightCalculatedAttribute($value)
    {
        $this->attributes['weight_calculated'] = DataHelper::getReal2Float($value);
    }

    public function setWeightFreightAttribute($value)
    {
        $this->attributes['weight_freight'] = DataHelper::getReal2Float($value);
    }

    public function setValueFreightAttribute($value)
    {
        $this->attributes['value_freight'] = DataHelper::getReal2Float($value);
    }

    public function setDespatchAttribute($value)
    {
        $this->attributes['despatch'] = DataHelper::getReal2Float($value);
    }

    public function setCatAttribute($value)
    {
        $this->attributes['cat'] = DataHelper::getReal2Float($value);
    }

    public function setItrAttribute($value)
    {
        $this->attributes['itr'] = DataHelper::getReal2Float($value);
    }

    public function setGrisAttribute($value)
    {
        $this->attributes['gris'] = DataHelper::getReal2Float($value);
    }

    public function setTollAttribute($value)
    {
        $this->attributes['toll'] = DataHelper::getReal2Float($value);
    }

    public function setTasAttribute($value)
    {
        $this->attributes['tas'] = DataHelper::getReal2Float($value);
    }

    public function setTdaAttribute($value)
    {
        $this->attributes['tda'] = DataHelper::getReal2Float($value);
    }

    public function setSuframaAttribute($value)
    {
        $this->attributes['suframa'] = DataHelper::getReal2Float($value);
    }

    public function setOthersAttribute($value)
    {
        $this->attributes['others'] = DataHelper::getReal2Float($value);
    }

    public function setCollectAttribute($value)
    {
        $this->attributes['collect'] = DataHelper::getReal2Float($value);
    }

    public function setTdcAttribute($value)
    {
        $this->attributes['tdc'] = DataHelper::getReal2Float($value);
    }

    public function setTdeAttribute($value)
    {
        $this->attributes['tde'] = DataHelper::getReal2Float($value);
    }

    public function setTarAttribute($value)
    {
        $this->attributes['tar'] = DataHelper::getReal2Float($value);
    }

    public function setTrtAttribute($value)
    {
        $this->attributes['trt'] = DataHelper::getReal2Float($value);
    }

    public function setFirstManifestedAtAttribute($value)
    {
        $this->attributes['first_manifested_at'] = DataHelper::setDate($value);
    }

    public function setLastManifestedAtAttribute($value)
    {
        $this->attributes['last_manifested_at'] = DataHelper::setDate($value);
    }

    public function setLastCargoAtAttribute($value)
    {
        $this->attributes['last_cargo_at'] = DataHelper::setDate($value);
    }

    public function setDeliveryPrevisionAttribute($value)
    {
        $this->attributes['delivery_prevision'] = DataHelper::setDate($value);
    }

    public function setDeliveredAtAttribute($value)
    {
        $this->attributes['delivered_at'] = DataHelper::setDate($value);
    }

    public function setCanceledAtAttribute($value)
    {
        $this->attributes['canceled_at'] = DataHelper::setDate($value);
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

	public function sender() //Remetente
	{
		return $this->belongsTo(Entity::class, 'sender_id');
	}

	public function dispatcher() //Expedidor
	{
		return $this->belongsTo(Entity::class, 'dispatcher_id');
	}

	public function payer() //Pagador
	{
		return $this->belongsTo(Entity::class, 'payer_id');
	}

	public function receiver() //Destinatário
	{
		return $this->belongsTo(Receiver::class, 'receiver_id');
	}

	public function partner()
	{
		return $this->belongsTo(Conveyor::class, 'partner_id');
	}


	public function horse()
	{
		return $this->belongsTo(Vehicle::class, 'horse_id');
	}

	public function cart()
	{
		return $this->belongsTo(Vehicle::class, 'cart_id');
	}

	public function deliver()
	{
		return $this->belongsTo(Vehicle::class, 'deliver_id');
	}

	public function commodity()
	{
		return $this->belongsTo(Commodity::class, 'commodity_id');
	}

	public function specie()
	{
		return $this->belongsTo(Specie::class, 'specie_id');
	}

	public function modality()
	{
		return $this->belongsTo(Modality::class, 'modality_id');
	}
	//============================================================
	//======================== HASONE ============================
	//============================================================

	//============================================================
	//======================== HASMANY ===========================
	//============================================================
	public function invoices()
	{
		return $this->hasMany(Invoice::class, 'moviment_id');
	}
	public function items()
	{
		return $this->hasMany(ContractItem::class, 'moviment_id');
	}


}
