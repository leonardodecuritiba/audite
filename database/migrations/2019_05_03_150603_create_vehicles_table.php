<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');

	        $table->string( 'plate', 10 );
	        $table->unsignedTinyInteger( 'contract_type' )->nullable();
	        $table->unsignedTinyInteger( 'vehicle_type' )->nullable();
	        $table->unsignedTinyInteger( 'bodywork_type' )->nullable();
	        $table->unsignedInteger( 'capacity' )->nullable();

	        $table->boolean( 'owner_type' )->default( 0 );
	        $table->string( 'owner_name', 100 )->nullable();
	        $table->string( 'owner_cpf', 20 )->nullable();
	        $table->string( 'owner_cnpj', 60 )->nullable();

	        $table->boolean( 'driver_type' )->default( 0 );
	        $table->string( 'driver_name', 100 )->nullable();
	        $table->string( 'driver_cpf', 20 )->nullable();
	        $table->string( 'driver_cnpj', 60 )->nullable();

	        $table->string( 'brand', 100 )->nullable();
	        $table->string( 'model', 100 )->nullable();

	        $table->boolean( 'active' )->default( 1 );

	        $table->timestamps();
	        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
