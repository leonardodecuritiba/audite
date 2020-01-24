<?php

namespace App\Http\Controllers\Moviments\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\ContractItemRequest;
use App\Models\Moviments\Contract;
use App\Models\Moviments\ContractItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class ContractItemController extends Controller {

    public $entity = "contracts";
    public $sex = "M";
    public $name = "Contratação";
    public $names = "Contratações";
    public $main_folder = 'pages.moviments.contracts';
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
     * @param  \App\Http\Requests\Moviments\ContractItemRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function save( ContractItemRequest $request, $id ) {
        $data = Contract::findOrFail( $id );
        //verificar se já não existe generalidade cadastrada.

        if($request->get('contract_item_id') == NULL){
            //store
            if($data->items->where('moviment_id',$request->get('moviment_id'))->count() == 0){
                ContractItem::create([
                    'contract_id'   => $id,
                    'moviment_id'   => $request->get('moviment_id')
                ]);
                return response()->success( 'Movimento adicionado!', $data,route(  'contracts.edit', $data->id ));
            }
            return response()->error( 'Movimento já adicionado!', $data,route(  'contracts.edit', $data->id ));
        } else {
            //update
            $data->generalities->find($request->get('contract_item_id'))->update($request->only('moviment_id'));
            return response()->success( 'Movimento atualizado!', $data,route(  'contracts.edit', $data->id ));
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  $id
     *
     * @return View
     */
    public function addItens( Request $request, $id ) {
	    $data = Contract::findOrFail( $id );
	    $nIds = $data->items->pluck('moviment_id')->toArray();
	    if($data->canShowEditBtn()){
		    $moviments = json_decode($request->get('moviments'));
		    foreach($moviments as $id){
		    	if(!in_array($id, $nIds)){
				    $dt[] = [
					    'moviment_id' => $id,
					    'contract_id' => $data->id
				    ];
			    }
		    }
		    ContractItem::insert($dt);
	    } else {
            return $this->error( "Esta contratação já foi finalizada! Impossível continuar." );
        }
        return $this->redirect( 'UPDATE', $data );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( $id ) {
        $data = ContractItem::find($id);
        $message = $this->getMessageFront( 'DELETE', 'Item : ' . $data->getShortName() );
        return new JsonResponse( [
            'status'  => $data->delete(),
            'message' => $message,
        ], 200 );
    }

}
