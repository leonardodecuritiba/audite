<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
	        $table->bigIncrements('id');

	        $table->unsignedBigInteger( 'vehicle_id' )->nullable();
	        $table->foreign( 'vehicle_id' )->references( 'id' )->on( 'vehicles' )->onDelete( 'cascade' );

	        $table->unsignedBigInteger( 'conveyor_id' )->nullable();
	        $table->foreign( 'conveyor_id' )->references( 'id' )->on( 'conveyors' )->onDelete( 'cascade' );

	        $table->unsignedTinyInteger( 'cost_type' );
	        $table->unsignedTinyInteger( 'contract_partner_type' )->default(1);

	        $table->date( 'contracted_at' );
	        $table->date( 'realized_at' );

	        $table->string( 'description', 100 )->nullable();
	        $table->decimal( 'value', 10,2 )->default( 0);
	        $table->string( 'payment_form', 100 )->nullable();
	        $table->date( 'payment_date' );

	        $table->tinyInteger( 'status')->default(0);

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
        Schema::dropIfExists('contracts');
    }
}
