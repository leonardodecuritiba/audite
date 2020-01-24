<?php

namespace App\Http\Controllers\Moviments;

use App\Filters\MovimentFilter;
use App\Helpers\DataHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\InvoiceImportRequest;
use App\Models\Moviments\Commons\Entity;
use App\Models\Moviments\Commons\Receiver;
use App\Models\Moviments\Conveyor;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class InvoiceController extends Controller {

    public $entity = "invoices";
    public $sex = "F";
    public $name = "Fatura";
    public $names = "Faturas";
    public $main_folder = 'pages.moviments.invoices';
    public $page = [];
    public $MovimentFilter;

    public function __construct( Route $route ) {
        $this->page = (object) [
            'entity'      => $this->entity,
            'main_folder' => $this->main_folder,
            'name'        => $this->name,
            'names'       => $this->names,
            'sex'         => $this->sex,
            'auxiliar'    => array(),
            'response'    => array(),
            'title'       => '',
            'create_option' => 0,
            'subtitle'    => '',
            'noresults'   => '',
            'tab'         => 'data',
            'breadcrumb'  => array(),
        ];
        $this->breadcrumb( $route );
	    $this->MovimentFilter = new MovimentFilter();
    }


	/**
	 * Import the specified resource in storage.
	 *
	 * @param InvoiceImportRequest $request
	 *
	 * @return Response
	 */
	public function import( Request $request ) {
		if ( $request->has( 'file_import' ) ) {
			$file = $request->file( 'file_import' ); //servidor
			set_time_limit( 3600 );
//            ini_set('memory_limit', '20000M');
//			$cnpj = "05683536000172";//05.683.536/0001-72
			$conveyor = Conveyor::findOrFail($request->get('partner_id'));
			$i = 0;

			$data = array();
			$reader = Excel::load($file, function ($sheet) use(&$data,$conveyor,&$i) {
				$sheet->each(function ($row) use(&$data,$conveyor,&$i) {
					$errors = array();

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
						$errors[] = "Sem CNPJ Remetente";
					} else {
						$sender = Entity::whereCnpj(DataHelper::getOnlyNumbers($row->cnpj_remetente))->first();
						if($sender == NULL){
							$errors[] = "CNPJ Remetente não encontrado: *".$row->cnpj_remetente."*";
						}
					}

					//RAZAO SOCIAL REMETENTE
					if($sender != NULL && $row->remetente == NULL){
						$errors[] = "Sem Remetente";
					} else {
						$sender = Entity::whereFantasyName($row->remetente)->first();
						if($sender == NULL){
							$errors[] = "Remetente não encontrado: *".$row->remetente."*";
						}
					}

					//CIDADE E UF REMETENTE
					if($sender != NULL){
						//CIDADE REMETENTE
						if($row->cidade_remetente == NULL){
							$errors[] = "Sem Cidade Remetente";
						} else {
							if(!$sender->checkCityName($row->cidade_remetente)){ //se a cidade não bater
								$errors[] = "Cidade Remetente: *".$row->cidade_remetente."*, difere do cadastrado: ".$sender->address->city->name;
							}
						}

						//UF REMETENTE
						if($row->uf_remetente == NULL){
							$errors[] = "Sem UF Remetente";
						} else {
							if(!$sender->checkUFName($row->uf_remetente)){ //se a uf não bater
								$errors[] = "UF Remetente: *".$row->uf_remetente."*, difere do cadastrado: ".$sender->address->state->short_name;
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
						$errors[] = "Sem CNPJ Destinatário";
					} else {
						$receiver = Receiver::whereCnpj(DataHelper::getOnlyNumbers($row->cnpj_destinatario))->first();
						if($receiver == NULL){
							$errors[] = "CNPJ Destinatário não encontrado: *".$row->cnpj_destinatario."*";
						}
					}

					//RAZAO SOCIAL DESTINATÁRIO
					$receiver = NULL;
					if($row->destinatario == NULL){
						$errors[] = "Sem Destinatário";
					} else {
						$receiver = Receiver::whereFantasyName($row->destinatario)->first();
						if($receiver == NULL){
							$errors[] = "Destinatário não encontrado: *".$row->destinatario."*";
						}
					}

					//CIDADE E UF DESTINATÁRIO
					if($receiver != NULL){
						//CIDADE DESTINATÁRIO
						if($row->cidade_destinatario == NULL){
							$errors[] = "Sem Cidade Destinatário";
						} else {
							if(!$receiver->checkCityName($row->cidade_destinatario)){ //se a cidade não bater
								$errors[] = "Cidade Destinatário: *".$row->cidade_destinatario."*, difere do cadastrado: ".$receiver->address->city->name;
							}
						}

						//UF REMETENTE
						if($row->uf_destinatario == NULL){
							$errors[] = "Sem UF Destinatário";
						} else {
							if(!$receiver->checkUFName($row->uf_destinatario)){ //se a uf não bater
								$errors[] = "UF Destinatário: *".$row->uf_destinatario."*, difere do cadastrado: ".$receiver->address->state->short_name;
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
						$errors[] = "CTE: *".$c."* para transportadora: *".$conveyor->getName()."* não encontrado!";
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
							$errors[]= $err_nf;
						}

						// VALOR NF
						if($row->valor_nf != $moviment->value){
							$errors[] = "Valor NF: *".$row->valor_nf."*, difere do movimento: ".$moviment->value;
						}

						// PESO CALCULADO
						if($row->peso_calculado != $moviment->weight_calculated){
							$errors[] = "Peso Calculado: *".$row->peso_calculado."*, difere do movimento: ".$moviment->weight_calculated;
						}

						// PESO EXC. KG

						// VOL
						if($row->vol != $moviment->volume_quantity){
							$errors[] = "Volume: *".$row->vol."*, difere do movimento: ".$moviment->volume_quantity;
						}

						// VALOR DO FRETE
						if($row->valor_do_frete != $moviment->value_freight){
							$errors[] = "Valor do frete: *".$row->valor_do_frete."*, difere do movimento: ".$moviment->value_freight;
						}
					}

					$data[$i] = $row->toArray();
					$data[$i]['errors'] = $errors;
					$i++;
				});
			})->ignoreEmpty();

			$this->page->response = $data;
			return view( 'pages.moviments.invoices.import' )
				->with( 'Page', $this->page );
			return response()->success( $this->getMessageFront( 'IMPORT' ), [], route( $this->entity . '.index' ) );
		} else {

			$this->page->auxiliar = [
				'partners'          => Conveyor::getAlltoSelectList(),
			];
			return view( 'pages.moviments.invoices.create-import' )
				->with( 'Page', $this->page );
		}

	}

}
