<?php

namespace App\Http\Controllers\Moviments\Settings;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\CityPriceTableRequest;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\PriceTables\PriceRangeC;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class PriceRangeCController extends Controller {

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
        $already = DB::table('price_range_c_s')->whereNull("deleted_at")
                                               ->where("conveyor_id", $id)->whereIn('city_id',$cities)->pluck('city_id')->toArray();

        foreach ($already as $a){
            unset($cities[array_search($a, $cities)]);
        }

        $arr = [];
        foreach ($cities as $city){
            $arr[] = [
                'conveyor_id' => $data->id,
                'value_d' => DataHelper::getReal2Float($request->get('value_d')),
                'excess_d' => DataHelper::getReal2Float($request->get('excess_d')),
                'value_c' => DataHelper::getReal2Float($request->get('value_c')),
                'excess_c' => DataHelper::getReal2Float($request->get('excess_c')),
                'city_id' => $city,
            ];
        }

        PriceRangeC::insert($arr);
        return response()->success( 'Cidade adicionada!', $data,route(  'conveyors.edit', $data->id ));

    }

}
