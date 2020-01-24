<?php

namespace App\Console\Commands;

use App\Helpers\DataHelper;
use App\Models\Commons\CepCities;
use App\Models\Commons\CepStates;
use App\Models\Moviments\Commons\Entity;
use App\Models\Moviments\Commons\Receiver;
use App\Models\Moviments\Conveyor;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Moviments\Moviment;
use Illuminate\Console\Command;

class InvoicesImport extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:invoices';

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

		$this->info( '* Moviments Check' );
		$start = microtime(true);

		$filename = 'fechamento_qualidade_new.xlsx';
		$filename = 'fechamento_girassol_new.xlsx';
		$filename = 'fechamento_teste.xlsx';

		$this->info( "*** Iniciando o Upload ***");
		$file = storage_path('imports' . DIRECTORY_SEPARATOR . $filename);

		set_time_limit(3600);


		$cnpj = "05683536000172";//05.683.536/0001-72
		$conveyor = Conveyor::whereCnpj($cnpj)->first();
		$i = 0;
		$errors = [];



		$reader = Excel::load($file, function ($sheet) use($conveyor,&$i,&$errors) {
			// Loop through all sheets
			$sheet->each(function ($row) use($conveyor,&$i,&$errors) {



				//================================================================
				//================================================================
				// VALIDAR:
				//      CNPJ REMETENTE,
				//      RAZAO SOCIAL REMETENTE,
				//      CIDADE REMETENTE,
				//      UF REMETENTE,

				//CNPJ REMETENTE
				$sender = NULL;
				if($row->cnpj_remetente == NULL){
					$errors[$i][] = "Sem CNPJ Remetente";
				} else {
					$sender = Entity::whereCnpj(DataHelper::getOnlyNumbers($row->cnpj_remetente))->first();
					if($sender == NULL){
						$errors[$i][] = "CNPJ Remetente não encontrado: *".$row->cnpj_remetente."*";
					}
				}

				//RAZAO SOCIAL REMETENTE
				if($sender != NULL && $row->remetente == NULL){
					$errors[$i][] = "Sem Remetente";
				} else {
					$sender = Entity::whereFantasyName($row->remetente)->first();
					if($sender == NULL){
						$errors[$i][] = "Remetente não encontrado: *".$row->remetente."*";
					}
				}

				//CIDADE E UF REMETENTE
				if($sender != NULL){
					//CIDADE REMETENTE
					if($row->cidade_remetente == NULL){
						$errors[$i][] = "Sem Cidade Remetente";
					} else {
						if(!$sender->checkCityName($row->cidade_remetente)){ //se a cidade não bater
							$errors[$i][] = "Cidade Remetente: *".$row->cidade_remetente."*, difere do cadastrado: ".$sender->address->city->name;
						}
					}

					//UF REMETENTE
					if($row->uf_remetente == NULL){
						$errors[$i][] = "Sem UF Remetente";
					} else {
						if(!$sender->checkUFName($row->uf_remetente)){ //se a uf não bater
							$errors[$i][] = "UF Remetente: *".$row->uf_remetente."*, difere do cadastrado: ".$sender->address->state->short_name;
						}
					}
				}

				//================================================================
				//================================================================
				// VALIDAR:
				//      CNPJ DESTINATÁRIO,
				//      RAZAO SOCIAL DESTINATÁRIO,
				//      CIDADE DESTINATÁRIO,
				//      UF DESTINATÁRIO,

				//CNPJ DESTINATÁRIO
				$receiver = NULL;
				if($row->cnpj_destinatario == NULL){
					$errors[$i][] = "Sem CNPJ Destinatário";
				} else {
					$receiver = Receiver::whereCnpj(DataHelper::getOnlyNumbers($row->cnpj_destinatario))->first();
					if($receiver == NULL){
						$errors[$i][] = "CNPJ Destinatário não encontrado: *".$row->cnpj_destinatario."*";
					}
				}

				//RAZAO SOCIAL DESTINATÁRIO
				$receiver = NULL;
				if($row->destinatario == NULL){
					$errors[$i][] = "Sem Destinatário";
				} else {
					$receiver = Receiver::whereFantasyName($row->destinatario)->first();
					if($receiver == NULL){
						$errors[$i][] = "Destinatário não encontrado: *".$row->destinatario."*";
					}
				}

				//CIDADE E UF DESTINATÁRIO
				if($receiver != NULL){
					//CIDADE DESTINATÁRIO
					if($row->cidade_destinatario == NULL){
						$errors[$i][] = "Sem Cidade Destinatário";
					} else {
						if(!$receiver->checkCityName($row->cidade_destinatario)){ //se a cidade não bater
							$errors[$i][] = "Cidade Destinatário: *".$row->cidade_destinatario."*, difere do cadastrado: ".$receiver->address->city->name;
						}
					}

					//UF REMETENTE
					if($row->uf_destinatario == NULL){
						$errors[$i][] = "Sem UF Destinatário";
					} else {
						if(!$receiver->checkUFName($row->uf_destinatario)){ //se a uf não bater
							$errors[$i][] = "UF Destinatário: *".$row->uf_destinatario."*, difere do cadastrado: ".$receiver->address->state->short_name;
						}
					}
				}

				//================================================================
				//================================================================
				// VALIDAR:
				//      N. CTE / N. COLETA,
				//      NOTAS FISCAIS
				//      VALOR NF
				//      PESO CALCULADO
				//      PESO EXC. KG
				//      VOL
				//      VALOR DO FRETE

				//NÚMERO CTE
				$c = $row->{'n._cte_n._coleta'};
				$moviment = $conveyor->moviments->where('cte_number', $c)->first();
				if($moviment == NULL){
					$errors[$i][] = "CTE: *".$c."* para transportadora: *".$conveyor->getName()."* não encontrado!";
				} else {

					// NOTAS FISCAIS
					$str = DataHelper::removeAllWhiteSpaces($row->notas_fiscais);
					$nfs = explode(',',$str);
//		return $moviment->invoices;
					$err_nf = [];
					foreach($nfs as $in => $nf){
						$nfa = explode('/',$nf);
						if($moviment->invoices->where('serie', $nfa[0])->where('number', $nfa[1])->count() <= 0){
							$err_nf[$in] = "NF: *".$nf."* não localizada.";
						}
					}
					if(count($err_nf) > 0){
						$errors[$i][]= $err_nf;
					}

					// VALOR NF
					if($row->valor_nf != $moviment->value){
						$errors[$i][] = "Valor NF: *".$row->valor_nf."*, difere do movimento: ".$moviment->value;
					}

					// PESO CALCULADO
					if($row->peso_calculado != $moviment->weight_calculated){
						$errors[$i][] = "Peso Calculado: *".$row->peso_calculado."*, difere do movimento: ".$moviment->weight_calculated;
					}

					// PESO EXC. KG

					// VOL
					if($row->vol != $moviment->volume_quantity){
						$errors[$i][] = "Volume: *".$row->vol."*, difere do movimento: ".$moviment->volume_quantity;
					}

					// VALOR DO FRETE
					if($row->valor_do_frete != $moviment->value_freight){
						$errors[$i][] = "Valor do frete: *".$row->valor_do_frete."*, difere do movimento: ".$moviment->value_freight;
					}
				}



//				dd($errors);

				$i++;
			});
		})->ignoreEmpty();
		dd(($errors));

		$this->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");
	}
}
