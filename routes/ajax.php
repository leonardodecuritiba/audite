<?php
/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('Commons')->middleware('auth')->prefix('commons')->group( function () {
    Route::get( 'state-city', 'CommonsController@getStateCityToSelect' )->name( 'ajax.get.state-city' );
    Route::get( 'conveyors-generalities/{conveyor}', 'CommonsController@getConveyorsGeneralitiesToSelect' )->name( 'ajax.get.conveyors-generalities' );
    Route::get( 'set-active', 'CommonsController@setActive' )->name( 'ajax.set.active' );
    Route::get( 'get-ajax-to-select2', 'CommonsController@ajaxSelect2' )->name('ajax.get-select2');
    Route::get( 'get-entities', 'CommonsController@getEntities' )->name( 'ajax.get.entities' );
	Route::get( 'get-receivers', 'CommonsController@getReceivers' )->name( 'ajax.get.receivers' );
	Route::get( 'get-partners', 'CommonsController@getPartners' )->name( 'ajax.get.partners' );

	Route::get( 'get-moviments/{contract}/filter', 'CommonsController@getMoviments' )->name( 'ajax.get.moviments' );
});

/*
|--------------------------------------------------------------------------
| HumanResources Routes
|--------------------------------------------------------------------------
|
*/
Route::namespace('HumanResources')->middleware('auth')->prefix('human_resources')->group( function () {
    Route::post( 'read-notification/{id}', 'NotificationController@read' )->name( 'ajax.human_resources.notification.read' );
    Route::post( 'read-all-notification', 'NotificationController@readAll' )->name( 'ajax.human_resources.notification.read-all' );
});
