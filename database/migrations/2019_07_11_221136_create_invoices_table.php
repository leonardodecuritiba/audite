<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
	        $table->bigIncrements('id');

	        $table->unsignedBigInteger( 'moviment_id' );
	        $table->foreign( 'moviment_id' )->references( 'id' )->on( 'moviments' )->onDelete( 'cascade' );

	        $table->string('serie',5);
	        $table->string('number',100);
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
        Schema::dropIfExists('invoices');
    }
}
