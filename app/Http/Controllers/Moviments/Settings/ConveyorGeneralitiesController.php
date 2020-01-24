<?php

namespace App\Http\Controllers\Moviments\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\ConveyorGeneralityRequest;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\Settings\ConveyorGeneralities;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;

class ConveyorGeneralitiesController extends Controller {

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
     * @param  \App\Http\Requests\Moviments\ConveyorGeneralityRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function save( ConveyorGeneralityRequest $request, $id ) {

        $data = Conveyor::findOrFail( $id );
        //verificar se já não existe generalidade cadastrada.

        if($request->get('conveyor_generality_id') == NULL){
            //store
            if($data->generalities->where('type',$request->get('generality_type'))->count() == 0){
                $dt['conveyor_id'] = $id;
                $dt['type'] = $request->get('generality_type');
                if($request->get('conveyor_generality_type') == 'percent') {
                    $dt['value'] = $request->get('value_percent');
                } else {
                    $dt['value'] = $request->get('value');
                }
                if($request->has('has_min')){
                    $dt['has_min'] = $request->has('has_min');
                    $dt['value_min'] = $request->has('value_min');
                } else {
                    $dt['has_min'] = false;
                }
                ConveyorGeneralities::create($dt);
                return response()->success( 'Custo geral adicionado!', $data,route(  'conveyors.edit', $data->id ));
            }
            return response()->error( 'Custo já adicionado!', $data,route(  'conveyors.edit', $data->id ));
        } else {
            //update
            dd(1);
            $data->generalities->find($request->get('conveyor_generality_id'))->update($request->only('value'));
            return response()->success( 'Custo geral atualizado!', $data,route(  'conveyors.edit', $data->id ));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( $id ) {
        $data = ConveyorGeneralities::find($id);
        $message = $this->getMessageFront( 'DELETE', 'Generalidade : ' . $data->getShortName() );
        return new JsonResponse( [
            'status'  => $data->delete(),
            'message' => $message,
        ], 200 );
    }

}
