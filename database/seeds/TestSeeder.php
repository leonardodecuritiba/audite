<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\Contract;
use App\Models\Moviments\ContractItem;
use App\Models\Moviments\Vehicle;
use App\Models\HumanResources\Client;
use App\Models\Moviments\Settings\ConveyorGeneralities;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=TestSeeder
	    Conveyor::flushEventListeners();
	    Conveyor::getEventDispatcher();
	    Vehicle::flushEventListeners();
	    Vehicle::getEventDispatcher();
	    Client::flushEventListeners();
	    Client::getEventDispatcher();
        ConveyorGeneralities::flushEventListeners();
        ConveyorGeneralities::getEventDispatcher();

	    //php artisan db:seed --class=TestSeeder
	    factory( Vehicle::class, 50 )->create();
	    $this->command->info( 'Vehicle complete ...' );

	    factory( Conveyor::class, 50 )->create();
	    $this->command->info( 'Conveyor complete ...' );

	    factory( Client::class, 50 )->create();
	    $this->command->info( 'Client complete ...' );

	    factory( ConveyorGeneralities::class, 100 )->create();
	    $this->command->info( 'ConveyorGeneralities complete ...' );

	    factory( Contract::class, 500 )->create();
	    $this->command->info( 'Contract complete ...' );
//
//	    factory( ContractItem::class, 500 )->create();
//	    $this->command->info( 'ContractItem complete ...' );

    }
}
