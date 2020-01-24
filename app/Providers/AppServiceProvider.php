<?php

namespace App\Providers;

use App\Models\HumanResources\Client;
use App\Models\HumanResources\User;
use App\Models\Moviments\Contract;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\Moviment;
use App\Models\Moviments\PriceTables\PriceRangeA;
use App\Models\Moviments\PriceTables\PriceRangeB;
use App\Models\Moviments\PriceTables\PriceRangeC;
use App\Models\Moviments\PriceTables\PriceRangeD;
use App\Models\Moviments\PriceTables\PriceRangeE;
use App\Models\Moviments\Vehicle;
use App\Observers\HumanResources\ClientObserver;
use App\Observers\HumanResources\UserObserver;
use App\Observers\Moviments\ContractObserver;
use App\Observers\Moviments\ConveyorObserver;
use App\Observers\Moviments\MovimentObserver;
use App\Observers\Moviments\PriceTables\PriceRangeAObserver;
use App\Observers\Moviments\PriceTables\PriceRangeBObserver;
use App\Observers\Moviments\PriceTables\PriceRangeCObserver;
use App\Observers\Moviments\PriceTables\PriceRangeDObserver;
use App\Observers\Moviments\PriceTables\PriceRangeEObserver;
use App\Observers\Moviments\VehicleObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    $this->app->singleton( FakerGenerator::class, function () {
		    return FakerFactory::create( 'pt_BR' );
	    } );
        Schema::defaultStringLength( 191 );
        User::observe( UserObserver::class );
        Client::observe( ClientObserver::class );
        Vehicle::observe( VehicleObserver::class );
        Conveyor::observe( ConveyorObserver::class );
        PriceRangeA::observe( PriceRangeAObserver::class );
        PriceRangeB::observe( PriceRangeBObserver::class );
        PriceRangeC::observe( PriceRangeCObserver::class );
        PriceRangeD::observe( PriceRangeDObserver::class );
        PriceRangeE::observe( PriceRangeEObserver::class );

        Moviment::observe( MovimentObserver::class );
        Contract::observe( ContractObserver::class );
    }
}
