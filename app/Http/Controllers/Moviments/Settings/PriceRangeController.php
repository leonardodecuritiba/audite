<?php

namespace App\Http\Controllers\Moviments\Settings;

use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\CityPriceTableRequest;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\PriceTables\PriceRangeA;
use App\Models\Moviments\PriceTables\PriceRangeB;
use App\Models\Moviments\PriceTables\PriceRangeC;
use App\Models\Moviments\PriceTables\PriceRangeD;
use App\Models\Moviments\PriceTables\PriceRangeE;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class PriceRangeController extends Controller {

    public $entity = "conveyors";
    public $sex = "F";
    public $name = "Tabela Frete";
    public $names = "Tabelas Frete";
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
	 * Remove the specified resource from storage.
	 *
	 * @param $id
	 * @param $type
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy( $id, $type ) {
		switch ($type){
			case 'A':
				$price_range = PriceRangeA::findOrFail($id);
				break;
			case 'B':
				$price_range = PriceRangeB::findOrFail($id);
				break;
			case 'C':
				$price_range = PriceRangeC::findOrFail($id);
				break;
			case 'D':
				$price_range = PriceRangeD::findOrFail($id);
				break;
			case 'E':
				$price_range = PriceRangeE::findOrFail($id);
				break;
		}
		$message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $price_range->getShortName() );
		return new JsonResponse( [
			'status'  => $price_range->delete(),
			'message' => $message,
		], 200 );
	}

}
