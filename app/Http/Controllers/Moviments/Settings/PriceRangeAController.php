<?php

namespace App\Http\Controllers\Moviments\Settings;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\CityPriceTableRequest;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\PriceTables\PriceRangeA;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class PriceRangeAController extends Controller {

    public $entity = "conveyors";
    public $sex = "M";
    public $name = "Transportadora";
    public $names = "Transportadoras";
    public $main_folder = 'pages.moviments.conveyors';
    public $page = [];
    public $ClientFilter;

    public function __construct( Route $route ) {
        $this->page = (object) [
            'entity'      => $this->entity,
            'main_folder' => $this->main_folder,
            'name'        => $this->name,
            'names'       => $this->names,
            'sex'         => $this->sex,
            'auxiliar'    => array(),
            'response'    => array(),
            'title'       => '',
            'create_option' => 0,
            'subtitle'    => '',
            'noresults'   => '',
            'tab'         => 'data',
            'breadcrumb'  => array(),
        ];
        $this->breadcrumb( $route );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Moviments\CityPriceTableRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function addCities( CityPriceTableRequest $request, $id ) {
        $data = Conveyor::findOrFail( $id );
        //verificar se já não existe cidade cadastrada.
        $cities = array_keys($request->get('cities'));
        $already = DB::table('price_range_a_s')->whereNull("deleted_at")
                     ->where("conveyor_id", $id)->whereIn('city_id',$cities)->pluck('city_id')->toArray();

        if(count($already)>0){
            return response()->error( 'As cidades adicionadas já estão ativas!', $data,route(  'conveyors.edit', $data->id ));
        }
        $arr = [];
        foreach ($cities as $city){
            $arr[] = [
                'conveyor_id' => $data->id,
                'value_a_d' => DataHelper::getReal2Float($request->get('value_a_d')),
                'value_b_d' => DataHelper::getReal2Float($request->get('value_b_d')),
                'value_c_d' => DataHelper::getReal2Float($request->get('value_c_d')),
                'value_d_d' => DataHelper::getReal2Float($request->get('value_d_d')),
                'value_e_d' => DataHelper::getReal2Float($request->get('value_e_d')),
                'value_f_d' => DataHelper::getReal2Float($request->get('value_f_d')),
                'excess_d' => DataHelper::getReal2Float($request->get('excess_d')),

                'value_a_c' => DataHelper::getReal2Float($request->get('value_a_c')),
                'value_b_c' => DataHelper::getReal2Float($request->get('value_b_c')),
                'value_c_c' => DataHelper::getReal2Float($request->get('value_c_c')),
                'value_d_c' => DataHelper::getReal2Float($request->get('value_d_c')),
                'value_e_c' => DataHelper::getReal2Float($request->get('value_e_c')),
                'value_f_c' => DataHelper::getReal2Float($request->get('value_f_c')),
                'excess_c' => DataHelper::getReal2Float($request->get('excess_c')),
                'city_id' => $city,
            ];
        }

        PriceRangeA::insert($arr);
        return response()->success( 'Cidades adicionadas!', $data,route(  'conveyors.edit', $data->id ));

    }

}
