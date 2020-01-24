<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangesUpdateV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conveyor_generalities', function (Blueprint $table) {
            $table->boolean('has_min')->default(0);
            $table->decimal('value_min', 10,2)->default(0);
            $table->decimal( 'value', 10,3 )->default( 0)->change();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conveyor_generalities', function (Blueprint $table) {
            $table->dropColumn('has_min');
            $table->dropColumn('value_min');
        });
    }
}
