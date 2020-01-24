<?php

namespace App\Http\AjaxControllers\Commons;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Models\Commons\CepCities;
use App\Models\Moviments\Commons\Entity;
use App\Models\Moviments\Commons\Receiver;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\Moviment;
use App\Models\Moviments\PriceTables\PriceRangeA;
use App\Models\Moviments\Settings\Generalities;
use App\Models\Moviments\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CommonsController extends Controller {
	/**
	 * gET the specified resource from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getStateCityToSelect() {
		$state_id = Input::get( 'id' );
		return ( $state_id == null ) ? $state_id : CepCities::where( 'state_id', $state_id )->get();
	}

    public function getEntities() {
        $value     = Input::has('value') ? Input::get('value') : '';
        return DataHelper::selectDefaultReturn('id', Entity::where('social_reason','like', $value.'%')->get());
    }

	public function getPartners() {
		$type     = Input::has('type') ? Input::get('type') : '';
		if($type == 1){
			$data = Vehicle::active()->get();
		} else {
			$data = Conveyor::active()->get();
		}
		return DataHelper::selectDefaultReturn('id', $data);
	}

    public function getReceivers() {
        $value     = Input::has('value') ? Input::get('value') : '';
        return DataHelper::selectDefaultReturn('id', Receiver::where('fantasy_name','like', $value.'%')->get());
    }

    public function getMoviments(Request $request, $id)
    {

		$n_ids = DB::table('contract_items')
            ->where('contract_id', $id)
            ->pluck('moviment_id');
		$query = DB::table('moviments')
					->join('entities','moviments.payer_id','entities.id')
		            ->whereNotIn('moviments.id', $n_ids); //retirar busca de movimentos pré-adicionados

        if($request->has('begin_date') && $request->get('begin_date') != NULL){
            $query = $query->where('moviments.created_at','>=', DataHelper::getPrettyToCorrectDate($request->get('begin_date')));
        }

	    if($request->has('end_date') && $request->get('end_date') != NULL){
		    $query = $query->where('moviments.created_at','<=',  DataHelper::getPrettyToCorrectDate($request->get('end_date')));
	    }

        if($request->has('state_id') && $request->get('state_id') != NULL) {
            $query = $query->join('receivers', 'receivers.id', 'moviments.receiver_id')
                ->join('addresses', 'addresses.id', 'receivers.address_id')
                ->where('addresses.state_id', $request->get('state_id'));
            if ($request->has('city_id') && $request->get('city_id') != NULL) {
                $query->where('addresses.city_id', $request->get('city_id'));
            }
        }

        $fds = ['cte_number', 'first_manifest', 'last_manifest', 'last_cargo'];

        foreach($fds as $f){
	        if($request->has($f) && $request->get($f) != NULL){
		        $query = $query->where($f,'like', "%".$request->get($f)."%");
	        }
        }

	    $data = $query->get(['moviments.id', 'cte_number', 'entities.fantasy_name', 'moviments.emitted_at'])->map(function($p){
	    	$p->emitted_at = DataHelper::getPrettyDateTime($p->emitted_at);
		    return $p;
	    });
        return DataHelper::selectDBReturn(['cte_number', 'fantasy_name', 'emitted_at'], $data);
    }
	/**
	 * gET the specified resource from storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getConveyorsGeneralitiesToSelect($conveyor_id) {
	    $types = DB::table('conveyor_generalities')->where('conveyor_id',$conveyor_id)->pluck('type')->toArray();

	    $gens = Generalities::all();
        foreach ($gens as $g){
            echo "comparando ".$g['id'];
            print_r($types);
            echo "<br>";

            if(array_search($g['id'], $types) != null){
                echo $g['id']."<br>";
            }
//            echo array_search($g['id'], $types)."-<br>";
//            unset($gens[array_search($g['id'], $types)]);

        }

        exit;

	    return $gens;
	    return $types;


        //Generalities::whereNotIn('id',$cities)->get()


		$state_id = Input::get( 'id' );
		return ( $state_id == null ) ? $state_id : CepCities::where( 'state_id', $state_id )->whereNotIn('id',$cities)->get(['id','name']);
	}

	/**
	 * Active the specified resource from storage.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setActive() {

		$model  = Input::get( 'model' );
		$id     = Input::get( 'id' );
		$Entity = $model::findOrFail( $id );

		return new JsonResponse( [
			'status'  => 1,
			'message' => $Entity->updateActive()
		], 200 );
	}

    public function getAjaxDataByID() {
        $id      = Input::get('id');
        $table   = Input::get('table');
        $retorno = explode(',',Input::get('retorno'));

        $response = DB::table($table)
                      ->where('id', $id)
                      ->get($retorno);

        return response()->json([ 'status' => '1',
                                  'response' => $response
        ]);
    }


    public function ajaxSelect2() {
        $id     = Input::get('id');
        $fk     = Input::get('fk');
        $field  = Input::get('field'); //status key
        $value  = Input::get('value'); //status key
        $table  = Input::get('table');
        $action = Input::get('action');
        if($value==NULL) return;
        $busca = NULL;
        switch($action){
            case 'get_by_id':
                $busca = DB::table($table)
                           ->where('id', $id)
                           ->get();
                break;
            case 'get_by_field':
                $busca = DB::table($table)
                           ->where($field,'like' , $value."%")
                           ->get();
                break;
            case 'busca_por_fk_campo':
                $busca = DB::table($table)
                           ->where($fk, $id)
                           ->where($field,'like' , $value . "%")
                           ->get();
                break;
        }
        $data = NULL;
        if( count($busca) > 0){
            foreach($busca as $i => $dt){
                $data[] = array( 'id' => $dt->id, 'text' => $dt->$field, 'data' => $dt);
            }
        }
        echo json_encode($data);
    }
}
