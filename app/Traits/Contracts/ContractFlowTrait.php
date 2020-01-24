<?php

namespace App\Traits\Contracts;

use App\Models\Commons\Logs;

trait ContractFlowTrait {

    public function close()
    {
    	//VALOR 1: Distribuição ponderada do valor da contratação, entre os CTes, baseado no peso calculado de cada um
    	$total = $this->items->sum(function($s){
    		return $s->moviment->weight_calculated;
	    });
	    $value = $this->value;
//	    echo "<br>TOTAL: ".$total."<br>";
//	    $tt = 0;
	    $this->items->each(function($s) use ($total,$value /*, &$tt*/){
		    $n = $s->moviment->invoices->count();
	    	$v = ($s->moviment->weight_calculated / $total);
		    $pv = round($v * $value,2);
		    $dv = round($pv/$n,2);
		    $s->update([
		    	'pondered_value'    => $pv,
		    	'distributed_value' => $dv,
		    ]);
//		    $tt += $v;
//	    	echo "<br>id: ".$s->id."| pc:".$s->moviment->weight_calculated."| v:".$v."| tt:".$tt;
	    });

        $this->update([
            'status'        => self::$_STATUS_CLOSED_,
        ]);

	    Logs::onChangeStatus([
		    'table' => $this->table,
		    'pk'    => $this->id,
		    'sk'    => self::$_STATUS_CLOSED_,
	    ]);
        return true;
    }

    public function cancel()
    {
        $this->update([
            'status'        => self::$_STATUS_CANCELED_,
        ]);

	    Logs::onChangeStatus([
		    'table' => $this->table,
		    'pk'    => $this->id,
		    'sk'    => self::$_STATUS_CANCELED_,
	    ]);
        return true;
    }

//	static public function open(Client $client)
//	{
//		$data = [
//			'client_id'         => $client->id,
//			'user_id'           => Auth::id(),
//			'cost_center_id'    => $client->cost_center_id,
//			'travel_cost'       => $client->getTotalTravelCost(),
//			'tolls'             => is_null($client->tolls) ? 0 : $client->tolls,
//			'other_cost'        => is_null($client->other_cost) ? 0 : $client->other_cost,
//			'total_value'       => 0,
//			'status'            => self::$_STATUS_ABERTA_
//
//		];
//		return self::create($data);
//	}
//
//	public function finish(array $request)
//	{
//		if (isset($request['exemption_cost'])) {
//			$custos = $this->attributes['travel_cost'] + $this->attributes['tolls'] + $this->attributes['other_cost'];
//			$this->attributes['travel_cost'] = 0;
//			$this->attributes['tolls'] = 0;
//			$this->attributes['other_cost'] = 0;
//			$this->attributes['final_value'] = $this->attributes['final_value'] - $custos;
//			$this->attributes['exemption_cost'] = 1;
////            $this->update_valores();
//		}
////        $this->attributes['numero_chamado'] = $request['numero_chamado'];
//		$this->attributes['responsible'] = $request['responsible'];
//		$this->attributes['responsible_cpf'] = $request['responsible_cpf'];
//		$this->attributes['responsible_position'] = $request['responsible_position'];
//		$this->attributes['finished_at'] = Carbon::now()->toDateTimeString();
//		$this->attributes['status'] = self::$_STATUS_FINALIZADA_;
//		return $this->save();
//	}


}