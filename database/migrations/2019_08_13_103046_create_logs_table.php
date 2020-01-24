<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
	        $table->unsignedBigInteger('creator_id')->nullable();
	        $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');

	        $table->string( 'verb', 6 )->nullable();
	        $table->string( 'table', 30 )->nullable();
	        $table->bigInteger( 'pk' )->nullable();
	        $table->bigInteger( 'sk' )->nullable();
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
