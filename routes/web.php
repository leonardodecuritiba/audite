<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Helpers\DataHelper;
use App\Models\Moviments\Commons\Entity;
use App\Models\Moviments\Commons\Receiver;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\Moviment;

Route::get('testing',function(){
	$cnpj = "05683536000172";//05.683.536/0001-72
	$conveyor = Conveyor::whereCnpj($cnpj)->first();
	$i = 0;
	$errors = [];


	$row = (object)[
		"data" => "16/10/2019",
		"tipo_servico" => "COLETA",

		"remetente" => "CORDIAL DISTR.DE.AUTOMOVEIS.LTDA",
		"cnpj_remetente" => "85102549000140",
		"cidade_remetente" => "CONCORDIA",
		"uf_remetente" => "SC",

		"destinatario" => "FIAT AUTOMOVEIS S/A",
		"cnpj_destinatario" => "16701716000156",
		"cidade_destinatario" => "BETIM",
		"uf_destinatario" => "MG",

		"n._cte_n._coleta" => "5000027305",
		"n._cte_n._coleta" => "3000095253",

		"notas_fiscais" => "1/70525 ",
		"notas_fiscais" => "3/37064 ",

		"valor_nf" => 1048.57,
		"peso_calculado" => 51.03,
		"peso_exc._kg" => null,
		"vol" => 2.0,
		"valor_do_frete" => 115.59,
		"informacoes_complementares" => null
	];





	//================================================================
	//================================================================
	// VALIDAR:
	//      CNPJ REMETENTE,
	//      RAZAO SOCIAL REMETENTE,
	//      CIDADE REMETENTE,
	//      UF REMETENTE,

	//CNPJ REMETENTE
	$sender = NULL;
	if($row->cnpj_remetente == NULL){
		$errors[$i][] = "Sem CNPJ Remetente";
	} else {
		$sender = Entity::whereCnpj(DataHelper::getOnlyNumbers($row->cnpj_remetente))->first();
		if($sender == NULL){
			$errors[$i][] = "CNPJ Remetente não encontrado: *".$row->cnpj_remetente."*";
		}
	}

	//RAZAO SOCIAL REMETENTE
	if($sender != NULL && $row->remetente == NULL){
		$errors[$i][] = "Sem Remetente";
	} else {
		$sender = Entity::whereFantasyName($row->remetente)->first();
		if($sender == NULL){
			$errors[$i][] = "Remetente não encontrado: *".$row->remetente."*";
		}
	}

	//CIDADE E UF REMETENTE
	if($sender != NULL){
		//CIDADE REMETENTE
		if($row->cidade_remetente == NULL){
			$errors[$i][] = "Sem Cidade Remetente";
		} else {
			if(!$sender->checkCityName($row->cidade_remetente)){ //se a cidade não bater
				$errors[$i][] = "Cidade Remetente: *".$row->cidade_remetente."*, difere do cadastrado: ".$sender->address->city->name;
			}
		}

		//UF REMETENTE
		if($row->uf_remetente == NULL){
			$errors[$i][] = "Sem UF Remetente";
		} else {
			if(!$sender->checkUFName($row->uf_remetente)){ //se a uf não bater
				$errors[$i][] = "UF Remetente: *".$row->uf_remetente."*, difere do cadastrado: ".$sender->address->state->short_name;
			}
		}
	}

	//================================================================
	//================================================================
	// VALIDAR:
	//      CNPJ DESTINATÁRIO,
	//      RAZAO SOCIAL DESTINATÁRIO,
	//      CIDADE DESTINATÁRIO,
	//      UF DESTINATÁRIO,

	//CNPJ DESTINATÁRIO
	$receiver = NULL;
	if($row->cnpj_destinatario == NULL){
		$errors[$i][] = "Sem CNPJ Destinatário";
	} else {
		$receiver = Receiver::whereCnpj(DataHelper::getOnlyNumbers($row->cnpj_destinatario))->first();
		if($receiver == NULL){
			$errors[$i][] = "CNPJ Destinatário não encontrado: *".$row->cnpj_destinatario."*";
		}
	}

	//RAZAO SOCIAL DESTINATÁRIO
	$receiver = NULL;
	if($row->destinatario == NULL){
		$errors[$i][] = "Sem Destinatário";
	} else {
		$receiver = Receiver::whereFantasyName($row->destinatario)->first();
		if($receiver == NULL){
			$errors[$i][] = "Destinatário não encontrado: *".$row->destinatario."*";
		}
	}

	//CIDADE E UF DESTINATÁRIO
	if($receiver != NULL){
		//CIDADE DESTINATÁRIO
		if($row->cidade_destinatario == NULL){
			$errors[$i][] = "Sem Cidade Destinatário";
		} else {
			if(!$receiver->checkCityName($row->cidade_destinatario)){ //se a cidade não bater
				$errors[$i][] = "Cidade Destinatário: *".$row->cidade_destinatario."*, difere do cadastrado: ".$receiver->address->city->name;
			}
		}

		//UF REMETENTE
		if($row->uf_destinatario == NULL){
			$errors[$i][] = "Sem UF Destinatário";
		} else {
			if(!$receiver->checkUFName($row->uf_destinatario)){ //se a uf não bater
				$errors[$i][] = "UF Destinatário: *".$row->uf_destinatario."*, difere do cadastrado: ".$receiver->address->state->short_name;
			}
		}
	}

	//================================================================
	//================================================================
	// VALIDAR:
	//      N. CTE / N. COLETA,
	//      NOTAS FISCAIS
	//      VALOR NF
	//      PESO CALCULADO
	//      PESO EXC. KG
	//      VOL
	//      VALOR DO FRETE

	//NÚMERO CTE
    $c = $row->{'n._cte_n._coleta'};
	$moviment = $conveyor->moviments->where('cte_number', $c)->first();
	if($moviment == NULL){
		$errors[$i][] = "CTE: *".$c."* para transportadora: *".$conveyor->getName()."* não encontrado!";
    } else {

		// NOTAS FISCAIS
        $str = DataHelper::removeAllWhiteSpaces($row->notas_fiscais);
        $nfs = explode(',',$str);
//		return $moviment->invoices;
		$err_nf = [];
		foreach($nfs as $in => $nf){
			$nfa = explode('/',$nf);
			if($moviment->invoices->where('serie', $nfa[0])->where('number', $nfa[1])->count() <= 0){
				$err_nf[$in] = "NF: *".$nf."* não localizada.";
            }
        }
        if(count($err_nf) > 0){
	        $errors[$i][]= $err_nf;
        }

		// VALOR NF
		if($row->valor_nf != $moviment->value){
			$errors[$i][] = "Valor NF: *".$row->valor_nf."*, difere do movimento: ".$moviment->value;
		}

		// PESO CALCULADO
		if($row->peso_calculado != $moviment->weight_calculated){
			$errors[$i][] = "Peso Calculado: *".$row->peso_calculado."*, difere do movimento: ".$moviment->weight_calculated;
		}

		// PESO EXC. KG

		// VOL
		if($row->vol != $moviment->volume_quantity){
			$errors[$i][] = "Volume: *".$row->vol."*, difere do movimento: ".$moviment->volume_quantity;
		}

		// VALOR DO FRETE
		if($row->valor_do_frete != $moviment->value_freight){
			$errors[$i][] = "Valor do frete: *".$row->valor_do_frete."*, difere do movimento: ".$moviment->value_freight;
		}
    }

	dd($errors);

});





Route::get('/', 'HomeController@index')->name('index');
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('phpinfo',function(){
    phpinfo();
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'namespace' => 'HumanResources','prefix' => 'human_resources', 'middleware' => 'auth' ], function () {

	Route::resource( 'users', 'UserController' );
	Route::get( 'my-profile', 'UserController@profile' )->name( 'profile.my' );
	Route::post( 'password-change', 'UserController@updatePassword' )->name( 'change.password' );
	Route::get( 'removeds', 'UserController@removeds' )->name( 'users.removeds' );
	Route::get( 'restore/{user}', 'UserController@restore' )->name( 'users.restore' );
	Route::post( 'user-password-change', 'UserController@updateUserPassword' )->name( 'users.change.password' );

	Route::resource( 'clients', 'ClientController' );
	Route::resource( 'notifications', 'NotificationController' );

} );

/*
|--------------------------------------------------------------------------
| Moviments Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'namespace' => 'Moviments','prefix' => 'moviments', 'middleware' => 'auth' ], function () {

	Route::group( [ 'namespace' => 'Settings','prefix' => 'settings', 'middleware' => 'auth' ], function () {
		Route::resource( 'cost_types', 'CostTypeController' );
        Route::post( 'price-range-a/add-cities/{conveyor}', 'PriceRangeAController@addCities' )->name( 'conveyors.price-range-a.add-cities' );
        Route::post( 'price-range-b/add-cities/{conveyor}', 'PriceRangeBController@addCities' )->name( 'conveyors.price-range-b.add-cities' );
        Route::post( 'price-range-c/add-cities/{conveyor}', 'PriceRangeCController@addCities' )->name( 'conveyors.price-range-c.add-cities' );
        Route::post( 'price-range-d/add-cities/{conveyor}', 'PriceRangeDController@addCities' )->name( 'conveyors.price-range-d.add-cities' );
        Route::post( 'price-range-e/add-cities/{conveyor}', 'PriceRangeEController@addCities' )->name( 'conveyors.price-range-e.add-cities' );

		Route::delete( 'price-range/destroy-city/{id}/{type}', 'PriceRangeController@destroy' )->name( 'conveyors.price-range.destroy-city' );

        Route::post( 'conveyor_generalities/save/{conveyor}', 'ConveyorGeneralitiesController@save' )->name( 'conveyor_generalities.save' );
        Route::delete( 'conveyor_generalities/{conveyor_generality_id}/delete', 'ConveyorGeneralitiesController@destroy' )->name( 'conveyor_generalities.delete' );

	} );

	Route::resource( 'vehicles', 'VehicleController' );
	Route::resource( 'conveyors', 'ConveyorController' );
    Route::get( 'conveyors/{conveyor}/destroy', 'ConveyorController@destroyType' )->name( 'conveyors.destroy-type' );

    Route::patch( 'conveyors/update-price/{conveyor}', 'ConveyorController@updatePriceTable' )->name( 'conveyors.update.price-table' );

    Route::resource( 'moviments', 'MovimentController' );
	Route::match( [
		'post',
		'get'
	], 'moviments-import', 'MovimentController@import' )->name( 'moviments.import' );
	Route::match( [
		'post',
		'get'
	], 'invoices-import', 'InvoiceController@import' )->name( 'invoices.import' );

	Route::resource( 'contracts', 'ContractController' );
	Route::get( 'contracts/{contract}/cancel', 'ContractController@cancel' )->name( 'contracts.cancel' );
	Route::get( 'contracts/{contract}/close', 'ContractController@close' )->name( 'contracts.close' );

	Route::group( [ 'namespace' => 'Settings'], function () {
		Route::post( 'contract_items/save/{contract}', 'ContractItemController@save' )->name( 'contract_items.save' );
		Route::post( 'contract_items/add/{contract}', 'ContractItemController@addItens' )->name( 'contract_items.add' );
		Route::delete( 'contract_items/{contract_item_id}/delete', 'ContractItemController@destroy' )->name( 'contract_items.delete' );


	} );
} );

/*
|--------------------------------------------------------------------------
| Reports Routes
|--------------------------------------------------------------------------
|
*/
Route::group( [ 'namespace' => 'Reports','prefix' => 'reports', 'middleware' => 'auth' ], function () {

    Route::get( 'nf', 'ReportController@nf' )->name( 'reports.nf' );
    Route::get( 'cte', 'ReportController@cte' )->name( 'reports.cte' );
    Route::get( 'cost', 'ReportController@cost' )->name( 'reports.cost' );

} );