<?php

namespace App\Http\Controllers\HumanResources;

use App\Filters\ClientFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\ClientRequest;
use App\Models\Commons\CepStates;
use App\Models\HumanResources\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class ClientController extends Controller {

    public $entity = "clients";
    public $sex = "M";
    public $name = "Cliente";
    public $names = "Clientes";
    public $main_folder = 'pages.human_resources.clients';
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
        $this->ClientFilter = new ClientFilter();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request) {
//        $clients = Client::class;
        $this->page->response = Client::get()->map( function ( $s ) {
            return [
                'id'                    => $s->id,
                'fantasy_name_text'     => $s->fantasy_name,
                'social_reason_text'    => $s->social_reason,
                'short_document'        => $s->short_document,
                'short_description'     => $s->short_description,
                'name'                  => $s->getShortName(),
                'email'                 => $s->email,
                'phone'                 => $s->contact->phone_formatted,
                'created_at'            => $s->created_at_formatted,
                'created_at_time'       => $s->created_at_time,
            ];
        } );

        $this->page->create_option = 1;
        return view('pages.human_resources.clients.index' )
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
        return view('pages.human_resources.clients.master' )
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
        $this->page->auxiliar = [
            'states' => CepStates::getAlltoSelectList(),
        ];
        $data = Client::findOrFail( $id );
        $this->page->create_option = 1;
        return view('pages.human_resources.clients.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }
    /**
     * Store the specified resource in storage.
     *
     * @param  \App\Http\Requests\HumanResources\ClientRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store( ClientRequest $request ) {
        $data = Client::create( $request->all() );
        return $this->redirect( 'STORE', $data );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\HumanResources\ClientRequest $request
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update( ClientRequest $request, $id ) {
        $data = Client::findOrFail( $id );
        $data->update( $request->all() );

        return $this->redirect( 'UPDATE', $data );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HumanResources\Client $client
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( Client $client ) {
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $client->getShortName() );
        return new JsonResponse( [
            'status'  => $client->delete(),
            'message' => $message,
        ], 200 );
    }
}
