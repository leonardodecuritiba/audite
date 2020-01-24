<?php

namespace App\Models\Moviments\Commons;

use App\Helpers\DataHelper;
use App\Models\Commons\CepStates;
use App\Models\HumanResources\Settings\Address;
use App\Models\Moviments\Moviment;
use App\Traits\AddressRelashionshipTrait;
use App\Traits\DateTimeTrait;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use AddressRelashionshipTrait;
	public $timestamps = true;
	static public $img_path = 'clients';

	protected $fillable = [
		'address_id',
		'fantasy_name',
		'cnpj',
	];

	protected $appends = [
		'cnpj_formatted',
		'short_description',
		'short_document'
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

    static public function getAlltoSelectList() {
        return self::active()->get()->map( function ( $s ) {
            return [
                'id'          => $s->id,
                'description' => $s->cnpj_formatted . " - " . $s->getName()
            ];
        } )->pluck( 'description', 'id' );
    }

	static public function import($row, $type)
	{
		switch ($type){
			case 'sender':
				$ADDRESS        = $row->endereco_do_remetente;
				$UF             = $row->uf_do_remetente;
				$CITY           = $row->cidade_do_remetente;
				$CEP            = $row->cep_do_remetente;
				$DISTRICT       = $row->bairro_do_remetente;
				$SOCIAL_REASON  = $row->cliente_remetente;
				$CNPJ           = $row->cnpj_remetente;
				break;
			case 'dispatcher':
				$ADDRESS        = NULL;
				$UF             = $row->uf_do_expedidor;
				$CITY           = $row->cidade_do_expedidor;
				$CEP            = NULL;
				$DISTRICT       = NULL;
				$SOCIAL_REASON  = $row->cliente_expedidor;
				$CNPJ           = $row->cnpj_expedidor;
				break;
			case 'payer':
				$ADDRESS        = $row->endereco_do_pagador;
				$UF             = $row->uf_do_pagador;
				$CITY           = $row->cidade_do_pagador;
				$CEP            = NULL;
				$DISTRICT       = $row->bairro_do_pagador;
				$SOCIAL_REASON  = $row->cliente_pagador;
				$CNPJ           = $row->cnpj_pagador;
				break;
		}


		$st = CepStates::findByUf($UF);
		if($st == NULL){
//			$this->command->alert( "*** ESTADO DO REMETENTE NÃO ENCONTRADA ***");
			echo( "*** ESTADO DO REMETENTE NÃO ENCONTRADA ***");
//			exit;
		}
		$ct = $st->findCityByName($CITY);
		if($ct == NULL){
//			$this->command->alert( "*** CIDADE DO REMETENTE NÃO ENCONTRADA ***");
			echo( "*** CIDADE DO REMETENTE NÃO ENCONTRADA ***");
//			exit;
		}


		$street = NULL;
		$complement = NULL;
		$ad = $ADDRESS;

		$number = filter_var($ad, FILTER_SANITIZE_NUMBER_INT);
		if($number != ""){
			$street = trim(strstr($ad, $number, true));
			$d = trim(strstr($ad, $number, false));
			$complement = trim(substr($d, strlen($number), strlen($d)));
		}
		$a = [
			'state_id'      => optional($st)->id,
			'city_id'       => optional($ct)->id,
			'city_code'     => NULL,
			'zip'           => DataHelper::getOnlyNumbers($CEP),
			'district'      => $DISTRICT,
			'street'        => $street,
			'number'        => $number,
			'complement'    => $complement,
			'region'        => NULL,
		];
		$a = Address::create($a);
		$e = [
			'address_id'    => $a->id,
			'fantasy_name'  => $SOCIAL_REASON,
			'cnpj'          => $CNPJ,
		];
		return self::create($e);
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
	//======================== ACCESSORS =========================
	//============================================================

	public function getShortName()
	{
		return $this->getAttribute('fantasy_name');
	}

	public function getName()
	{
		return $this->getShortName();
	}

	public function getShortDescriptionAttribute()
	{
		return $this->getShortName();
	}

	public function getShortDocumentAttribute()
	{
		return $this->cnpj_formatted;
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

	//============================================================
	//======================== HASONE ============================
	//============================================================

	//============================================================
	//======================== HASMANY ===========================
	//============================================================
	public function moviments_sender()
	{
		return $this->hasMany(Moviment::class, 'sender_id');
	}

	public function moviments_dispatcher()
	{
		return $this->hasMany(Moviment::class, 'dispatcher_id');
	}

	public function moviments_payer()
	{
		return $this->hasMany(Moviment::class, 'payer_id');
	}


}
