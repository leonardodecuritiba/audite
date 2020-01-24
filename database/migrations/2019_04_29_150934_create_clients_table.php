<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger( 'contact_id' );
            $table->foreign( 'contact_id' )->references( 'id' )->on( 'contacts' )->onDelete( 'cascade' );

            $table->unsignedInteger( 'address_id' );
            $table->foreign( 'address_id' )->references( 'id' )->on( 'addresses' )->onDelete( 'cascade' );

            $table->boolean( 'type' )->default( 0 );
            $table->string( 'name', 100 )->nullable();
            $table->string( 'social_reason', 100 )->nullable();
            $table->string( 'fantasy_name', 100 )->nullable();

            $table->string( 'cpf', 20 )->nullable();
            $table->string( 'cnpj', 60 )->nullable();

            $table->string( 'observations', 500 )->nullable();
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
        Schema::dropIfExists('clients');
    }
}
