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
use Illuminate\Support\Facades\DB;

class Receiver extends Model
{
	use SoftDeletes;
	use DateTimeTrait;
	use StringTrait;
	use AddressRelashionshipTrait;
	public $timestamps = true;

	protected $fillable = [
		'address_id',

		'fantasy_name',
		'cnpj',
		'plate',
	];

	protected $appends = [
		'cnpj_formatted',
		'short_description',
		'short_document'
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================

	public function getConveyourId(){
		//PROCURAR $this->address->city_id EM
		$city_id = $this->address->city_id;
		$tables = ['a','b','c','d','e'];
		$db = NULL;
		foreach($tables as $table){
			$db = DB::table('price_range_' . $table . '_s')
			        ->whereNull('deleted_at')
			        ->where('city_id', $city_id)
			        ->first();
			if($db != NULL){
				return $db->conveyor_id;
			}
		}
		return $db;
	}

	static public function import($row)
	{
		$ADDRESS        = $row->endereco_do_destinatario;
		$UF             = $row->uf_do_destinatario;
		$CITY           = $row->cidade_do_destinatario;
		$CEP            = $row->cep_do_destinatario;
		$DISTRICT       = $row->bairro_do_destinatario;
		$SOCIAL_REASON  = $row->cliente_destinatario;
		$CNPJ           = $row->cnpj_destinatario;
		$PLACA          = $row->praca_de_destino;


		$st = CepStates::findByUf($UF);
		if($st == NULL){
//			$this->command->alert( "*** ESTADO DO REMETENTE NÃO ENCONTRADA ***");
			echo( "*** ESTADO DO DESTINATARIO NÃO ENCONTRADA ***");
//			exit;
		}
		$ct = $st->findCityByName($CITY);
		if($ct == NULL){
//			$this->command->alert( "*** CIDADE DO REMETENTE NÃO ENCONTRADA ***");
			echo( "*** CIDADE DO DESTINATARIO NÃO ENCONTRADA ***");
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
			'plate'         => $PLACA,
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
	public function moviments_receiver()
	{
		return $this->hasMany(Moviment::class, 'receiver_id');
	}

}
