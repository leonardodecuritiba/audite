<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceRangeBSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_range_b_s', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger( 'conveyor_id' );
            $table->foreign( 'conveyor_id' )->references( 'id' )->on( 'conveyors' )->onDelete( 'cascade' );

            $table->unsignedInteger( 'city_id' );
            $table->foreign( 'city_id' )->references( 'id' )->on( 'cep_cities' )->onDelete( 'cascade' );

            $table->decimal( 'value_d', 10,2 )->default( 0);
            $table->decimal( 'excess_d', 10,2 )->default( 0);

            $table->decimal( 'value_c', 10,2 )->default( 0);
            $table->decimal( 'excess_c', 10,2 )->default( 0);

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
        Schema::dropIfExists('price_range_b_s');
    }
}
