<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Moviments\Moviment;
use Illuminate\Console\Command;

class MovimentsImport extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:moviments';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		Moviment::flushEventListeners();
		Moviment::getEventDispatcher();

		$this->info( '* Import Moviments' );
		$start = microtime(true);

		$filename = 'moviments_resumed.xls';

		$this->info( "*** Iniciando o Upload ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);


		$reader = Excel::load($file, function ($sheet) {
			// Loop through all sheets
			$sheet->each(function ($row) {


				dd($row[0]);






				$brand = Brand::whereDescription($row->description)->first();
				if($brand == NULL){
					$id = DB::table('brands')->insertGetId([
						'created_at'            => $row->created_at,
						'idmarca'       => $row->idmarca,
						'description'   => $row->description,
					]);
				} else {
					$this->command->alert('MARCA EXISTENTE: ' . $brand->description . ', idmarca: ' . $brand->id);
					$id = $brand->id;
				}

				$this->info( "****************** (" . $id . ") ******************");

			});
		})->ignoreEmpty();

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
