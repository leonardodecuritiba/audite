<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moviments', function (Blueprint $table) {
            $table->bigIncrements('id');

	        $table->unsignedBigInteger( 'sender_id' ); //Remetente
	        $table->foreign( 'sender_id' )->references( 'id' )->on( 'entities' )->onDelete( 'cascade' );

	        $table->unsignedBigInteger( 'dispatcher_id' ); //Expedidor
	        $table->foreign( 'dispatcher_id' )->references( 'id' )->on( 'entities' )->onDelete( 'cascade' );

	        $table->unsignedBigInteger( 'payer_id' ); //Pagador
	        $table->foreign( 'payer_id' )->references( 'id' )->on( 'entities' )->onDelete( 'cascade' );

	        $table->unsignedBigInteger( 'receiver_id' ); //Destinatário
	        $table->foreign( 'receiver_id' )->references( 'id' )->on( 'receivers' )->onDelete( 'cascade' );


	        $table->unsignedInteger( 'commodity_id' );
	        $table->foreign( 'commodity_id' )->references( 'id' )->on( 'commodities' )->onDelete( 'cascade' );

	        $table->unsignedInteger( 'specie_id' );
	        $table->foreign( 'specie_id' )->references( 'id' )->on( 'species' )->onDelete( 'cascade' );

	        $table->unsignedInteger( 'modality_id' );
	        $table->foreign( 'modality_id' )->references( 'id' )->on( 'modalities' )->onDelete( 'cascade' );

	        $table->unsignedBigInteger( 'horse_id' )->nullable();
	        $table->foreign( 'horse_id' )->references( 'id' )->on( 'vehicles' )->onDelete( 'cascade' )->nullable();

	        $table->unsignedBigInteger( 'cart_id' )->nullable();
	        $table->foreign( 'cart_id' )->references( 'id' )->on( 'vehicles' )->onDelete( 'cascade' )->nullable();

	        $table->unsignedBigInteger( 'deliver_id' )->nullable();
	        $table->foreign( 'deliver_id' )->references( 'id' )->on( 'vehicles' )->onDelete( 'cascade' )->nullable();

	        $table->unsignedBigInteger( 'partner_id' )->nullable();
	        $table->foreign( 'partner_id' )->references( 'id' )->on( 'conveyors' )->onDelete( 'cascade' );

	        $table->string( 'destiny_unity', 100 )->nullable();

	        $table->string( 'ctrc', 20 )->nullable();
	        $table->string( 'cte_number', 20 )->nullable();
	        $table->tinyInteger( 'document_type');
	        $table->dateTime( 'emitted_at' )->nullable();
	        $table->string( 'cte_key', 60 )->nullable();

	        $table->string( 'nf_number', 20 )->nullable();
	        $table->decimal( 'real_weight', 10,2 )->default( 0);
	        $table->decimal( 'cubage', 10,2 )->default( 0);
	        $table->mediumInteger( 'volume_quantity');
	        $table->boolean( 'freight');

	        $table->decimal( 'value', 10,2 )->default( 0);
	        $table->tinyInteger( 'calculus_type');
	        $table->string( 'calculus_table', 20 )->nullable();
	        $table->decimal( 'freight_value', 10,2 )->default( 0);

	        $table->decimal( 'freight_icms', 10,2 )->default( 0);
	        $table->decimal( 'calculus_basis', 10,2 )->default( 0);
	        $table->decimal( 'icms_value', 10,2 )->default( 0);
	        $table->decimal( 'aliquot', 5,2 )->default( 0);

	        $table->decimal( 'iss_value', 10,2 )->default( 0);
	        $table->decimal( 'weight_calculated', 10,2 )->default( 0);
	        $table->decimal( 'weight_freight', 10,2 )->default( 0);

	        $table->decimal( 'value_freight', 10,2 )->default( 0);
	        $table->decimal( 'despatch', 10,2 )->default( 0);
	        $table->decimal( 'cat', 10,2 )->default( 0);
	        $table->decimal( 'itr', 10,2 )->default( 0);
	        $table->decimal( 'gris', 10,2 )->default( 0);
	        $table->decimal( 'toll', 10,2 )->default( 0);
	        $table->decimal( 'tas', 10,2 )->default( 0);
	        $table->decimal( 'tda', 10,2 )->default( 0);

	        $table->decimal( 'suframa', 10,2 )->default( 0);
	        $table->decimal( 'others', 10,2 )->default( 0);
	        $table->decimal( 'collect', 10,2 )->default( 0);
	        $table->decimal( 'tdc', 10,2 )->default( 0);
	        $table->decimal( 'tde', 10,2 )->default( 0);
	        $table->decimal( 'tar', 10,2 )->default( 0);
	        $table->decimal( 'trt', 10,2 )->default( 0);

	        $table->string( 'first_manifest', 20 )->nullable();
	        $table->date( 'first_manifested_at' )->nullable();
	        $table->string( 'last_manifest', 20 )->nullable();
	        $table->date( 'last_manifested_at' )->nullable();
	        $table->string( 'last_cargo', 20 )->nullable();
	        $table->date( 'last_cargo_at' )->nullable();

	        $table->mediumInteger( 'last_occurrence_code');
	        $table->date( 'delivery_prevision' )->nullable();
	        $table->date( 'delivered_at' )->nullable();
	        $table->date( 'canceled_at' )->nullable();
	        $table->string( 'canceled_reason', 500 )->nullable();
	        $table->string( 'request_number', 100 )->nullable();

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
        Schema::dropIfExists('moviments');
    }
}
