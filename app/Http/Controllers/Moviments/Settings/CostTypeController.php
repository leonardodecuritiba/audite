<?php

namespace App\Http\Controllers\Moviments\Settings;

use App\Http\Controllers\Controller;
use App\Models\Moviments\Settings\CostTypes;
use Illuminate\Routing\Route;

class CostTypeController extends Controller {

    public $entity = "cost_types";
    public $sex = "M";
    public $name = "Tipo de Custo";
    public $names = "Tipos de Custo";
    public $main_folder = 'pages.moviments.settings.cost_types';
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

    public function index() {
        $this->page->response = CostTypes::all();
        $this->page->create_option = 0;
        return view('pages.moviments.settings.cost_types.index' )
            ->with( 'Page', $this->page );
    }

}
