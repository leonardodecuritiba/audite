<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
	        $table->bigIncrements('id');

			$table->unsignedInteger( 'address_id' );
			$table->foreign( 'address_id' )->references( 'id' )->on( 'addresses' )->onDelete( 'cascade' );

			$table->string( 'fantasy_name', 100 )->nullable();
			$table->string( 'cnpj', 60 )->nullable();

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
        Schema::dropIfExists('entities');
    }
}
