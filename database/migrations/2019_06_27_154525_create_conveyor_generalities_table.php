<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConveyorGeneralitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conveyor_generalities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger( 'conveyor_id' );
            $table->foreign( 'conveyor_id' )->references( 'id' )->on( 'conveyors' )->onDelete( 'cascade' );

            $table->unsignedTinyInteger( 'type' );
            $table->decimal( 'value', 10,2 )->default( 0);

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
        Schema::dropIfExists('conveyor_generalities');
    }
}
