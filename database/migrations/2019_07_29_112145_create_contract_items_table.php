<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_items', function (Blueprint $table) {
            $table->bigIncrements('id');

	        $table->unsignedBigInteger( 'moviment_id' );
	        $table->foreign( 'moviment_id' )->references( 'id' )->on( 'moviments' )->onDelete( 'cascade' );

	        $table->unsignedBigInteger( 'contract_id' );
	        $table->foreign( 'contract_id' )->references( 'id' )->on( 'contracts' )->onDelete( 'cascade' );

	        $table->decimal( 'pondered_value', 10,2 )->default( 0);
	        $table->decimal( 'distributed_value', 10,2 )->default( 0);

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
        Schema::dropIfExists('contract_items');
    }
}
