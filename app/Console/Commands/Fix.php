<?php

namespace App\Console\Commands;

use App\Helpers\DataHelper;
use App\Models\Commons\CepCities;
use App\Models\Commons\CepStates;
use App\Models\Moviments\Commons\Entity;
use App\Models\Moviments\Commons\Invoice;
use App\Models\Moviments\Commons\Receiver;
use App\Models\Moviments\Conveyor;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Moviments\Moviment;
use Illuminate\Console\Command;

class Fix extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:fix';

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
		Invoice::all()->each(function($i){
			$i->update(['number'=>DataHelper::removeAllWhiteSpaces($i->number)]);
		});

		$this->alert( 'Fix FINISHED ');
	}
}
