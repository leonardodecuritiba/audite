<?php

namespace App\Traits\Contracts;

trait ContractStatusTrait {

    static $_STATUS_OPENNED_ = 0;
    static $_STATUS_CLOSED_ = 1;
    static $_STATUS_CANCELED_ = 2;

	static public function getAllStatustoSelectList()
	{
		return [
			'0'  => 'EM ANDAMENTO',
			'1'  => 'FECHADA',
			'2'  => 'CANCELADA',
		];
	}

	public function getStatusArrayAttribute()
	{
		return [
			'text'  => $this->getStatusTextAttribute(),
			'color' => $this->getStatusColorAttribute(),
		];
	}

    public function getStatusColorAttribute()
    {
        switch ($this->getAttribute('status')){
            case self::$_STATUS_OPENNED_:
                return 'info';
	        case self::$_STATUS_CLOSED_:
		        return 'success';
            case self::$_STATUS_CANCELED_:
                return 'danger';
        }
    }

    public function getStatusIconAttribute()
    {
        switch ($this->getAttribute('status')){
            case self::$_STATUS_OPENNED_:
                return 'compare_arrows';
            case self::$_STATUS_CLOSED_:
                return 'done';
            case self::$_STATUS_CANCELED_:
                return 'report_problem';
        }
    }

    public function getStatusTextAttribute()
    {
	    switch($this->getAttribute('status')){
		    case self::$_STATUS_OPENNED_:
		    	return 'EM ANDAMENTO';
		    case self::$_STATUS_CLOSED_:
		    	return 'FECHADA';
		    case self::$_STATUS_CANCELED_:
		    	return 'CANCELADA';
	    }
    }

    static public function getStatusText($value)
    {
	    switch($value){
		    case self::$_STATUS_OPENNED_:
		    	return 'EM ANDAMENTO';
		    case self::$_STATUS_CLOSED_:
		    	return 'FECHADA';
		    case self::$_STATUS_CANCELED_:
		    	return 'CANCELADA';
	    }
    }

    static public function getStatusColor($value)
    {
	    switch($value){
		    case self::$_STATUS_OPENNED_:
			    return 'info';
		    case self::$_STATUS_CLOSED_:
			    return 'success';
		    case self::$_STATUS_CANCELED_:
			    return 'danger';
	    }
    }


    public function isClosed() //RETORNA O STATUS 0:ABERTA 1:FECHADA
    {
        return (($this->getAttribute('status') == self::$_STATUS_CLOSED_) ||
                ($this->getAttribute('status') == self::$_STATUS_CANCELED_)
        );
    }


	/**
	 * Scope a query to only include active.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeClosed($query)
	{
		return $query->where('status', self::$_STATUS_CLOSED_);
	}
	/**
	 * Scope a query to only include active.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeCanceled($query)
	{
		return $query->where('status', self::$_STATUS_CANCELED_);
	}
	/**
	 * Scope a query to only include active.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOpenned($query)
	{
		return $query->where('status', self::$_STATUS_OPENNED_);
	}

}