<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConveyorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conveyors', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger( 'contact_id' );
            $table->foreign( 'contact_id' )->references( 'id' )->on( 'contacts' )->onDelete( 'cascade' );

            $table->unsignedInteger( 'address_id' );
            $table->foreign( 'address_id' )->references( 'id' )->on( 'addresses' )->onDelete( 'cascade' );

            $table->string( 'initials', 3 );
            $table->boolean( 'type' )->default( 0 );
            $table->string( 'cpf', 20 )->nullable();
            $table->string( 'cnpj', 60 )->nullable();

            $table->string( 'ie', 20 )->nullable();

            $table->string( 'social_reason', 100 );

            $table->string( 'description', 100 )->nullable();
            $table->unsignedTinyInteger( 'priority_type' )->nullable();
            $table->unsignedTinyInteger( 'price_type' )->nullable();


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
        Schema::dropIfExists('conveyors');
    }
}
