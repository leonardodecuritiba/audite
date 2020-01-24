<?php

namespace App\Models\Commons;

use App\Models\HumanResources\User;
use App\Traits\Contracts\ContractStatusTrait;
use App\Traits\DateTimeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Logs extends Model {
	use DateTimeTrait;
	public $timestamps = true;
	protected $fillable = [
		'creator_id',
		'verb',
		'table',
		'pk',
		'sk',
	];

	protected $appends = [
		'validated_at',
		'created_at_formatted',
		'created_at_human_formatted',
		'log_text',
		'log_color',
	];


	//============================================================
	//======================== FUNCTIONS =========================
	//============================================================
	public function getCreatorName()
	{
		return $this->creator->getName();
	}

	public function getLogTextAttribute()
	{
		switch ($this->getAttribute('verb')){
			case 'CREATE':
				return 'Criação';
			case 'UPDATE':
				return 'Atualização';
			case 'DELETE':
				return 'Remoção';
			case 'STATUS':
				return 'Alteração de STATUS para '.$this->getLogSkText();
		}
	}

	public function getLogColorAttribute()
	{
		switch ($this->getAttribute('verb')){
			case 'CREATE':
				return 'info';
			case 'UPDATE':
				return 'warning';
			case 'DELETE':
				return 'danger';
			case 'STATUS':
				return $this->getLogSkColor();
		}
	}

	public function getLogSkText()
	{
		switch ($this->getAttribute('table')){
			case 'contracts':
				return ContractStatusTrait::getStatusText($this->getAttribute('sk'));
		}
	}

	public function getLogSkColor()
	{
		switch ($this->getAttribute('table')){
			case 'contracts':
				return ContractStatusTrait::getStatusColor($this->getAttribute('sk'));
		}
	}

	static public function onCreate(array $attributes)
	{
		$attributes['creator_id'] = Auth::id();
		$attributes['verb'] = 'CREATE';
		return parent::create($attributes);
	}

	static public function onUpdate(array $attributes)
	{
		$attributes['creator_id'] = Auth::id();
		$attributes['verb'] = 'UPDATE';
		return parent::create($attributes);
	}

	static public function onDelete(array $attributes)
	{
		$attributes['creator_id'] = Auth::id();
		$attributes['verb'] = 'DELETE';
		return parent::create($attributes);
	}
	//============================================================
	static public function onChangeStatus(array $attributes)
	{
		$attributes['creator_id'] = Auth::id();
		$attributes['verb'] = 'STATUS';
		return parent::create($attributes);
	}

	//============================================================
	//======================== RELASHIONSHIP =====================
	//============================================================
	public function creator()
	{
		return $this->belongsTo( User::class, 'creator_id' );
	}
}
