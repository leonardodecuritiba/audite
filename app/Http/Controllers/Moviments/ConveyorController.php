<?php

namespace App\Http\Controllers\Moviments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\ConveyorRequest;
use App\Http\Requests\Moviments\PriceTableRequest;
use App\Models\Commons\CepStates;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\Settings\Generalities;
use App\Models\Moviments\Settings\PriceTypes;
use App\Models\Moviments\Settings\PriorityTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class ConveyorController extends Controller {

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
        $data = Conveyor::get()->map( function ( $s ) {
            return [
                'id'                    => $s->id,
                'initials'              => $s->getShortName(),
                'name'                  => $s->getName(),
//                'price_type_formatted'  => $s->price_type_formatted,
                'document_formatted'    => $s->document_formatted,
                'social_reason'         => $s->social_reason,

                'created_at'            => $s->created_at_formatted,
                'created_at_time'       => $s->created_at_time,
                'active'                => $s->getActiveFullResponse()
            ];
        } );;
        $this->page->response = $data;

        $this->page->create_option = 1;
        return view('pages.moviments.conveyors.index' )
            ->with( 'Page', $this->page );
    }

    /**
     * Create the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function create( ) {
        $this->page->auxiliar = [
            'states' => CepStates::getAlltoSelectList(),
        ];
        return view('pages.moviments.conveyors.master' )
            ->with( 'Page', $this->page );
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id ) {
        $data = Conveyor::findOrFail( $id );
        $this->page->auxiliar = [
            'states'            => CepStates::getAlltoSelectList(),
            'priority_types'    => PriorityTypes::getAlltoSelectList(),
            'price_types'       => PriceTypes::getAlltoSelectList(),
            'generalities'      => Generalities::all(),
        ];

        $this->page->create_option = 1;
        return view('pages.moviments.conveyors.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }
    /**
     * Store the specified resource in storage.
     *
     * @param  \App\Http\Requests\Moviments\ConveyorRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( ConveyorRequest $request ) {
        $data = Conveyor::create( $request->all() );
        return $this->redirect( 'STORE', $data );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Moviments\ConveyorRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( ConveyorRequest $request, $id ) {
        $data = Conveyor::findOrFail( $id );
        $data->update( $request->all() );

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Moviments\PriceTableRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePriceTable( PriceTableRequest $request, $id ) {
        $data = Conveyor::findOrFail( $id );
        $data->update( $request->all() );

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Moviments\Conveyor $conveyor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyType( $id ) {
        $data = Conveyor::findOrFail( $id );

        foreach ($data->getPriceRange() as $price){
            $price->delete();
        }

        $data->update([
            'description'   => NULL,
            'priority_type' => NULL,
            'price_type'    => NULL,
        ]);

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Moviments\Conveyor $conveyor
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( Conveyor $conveyor ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $conveyor->getShortName() );
        return new JsonResponse( [
            'status'  => $conveyor->delete(),
            'message' => $message,
        ], 200 );
    }
}
