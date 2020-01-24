<?php

use Illuminate\Database\Seeder;

class ImportCepTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run() {
		//php artisan db:seed --class=ImportCepTable
		$start = microtime( true );
		$this->command->info( 'Import CEPS' );
		ini_set('memory_limit', '-1');
		$file = storage_path('imports/cep-states-cities.sql') ;
		$sql = "mysql -u ".config('database.connections.mysql.username')
            ." -p".config('database.connections.mysql.password')
            ." ".config('database.connections.mysql.database')." < " . $file;
		exec($sql);
		$this->command->info( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
