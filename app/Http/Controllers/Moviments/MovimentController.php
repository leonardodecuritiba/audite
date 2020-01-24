<?php

namespace App\Http\Controllers\Moviments;

use App\Filters\MovimentFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Moviments\MovimentImportRequest;
use App\Http\Requests\Moviments\MovimentRequest;
use App\Models\Moviments\Commons\CalculusType;
use App\Models\Moviments\Commons\Commodity;
use App\Models\Moviments\Commons\DocumentType;
use App\Models\Moviments\Commons\Entity;
use App\Models\Moviments\Commons\Modality;
use App\Models\Moviments\Commons\Receiver;
use App\Models\Moviments\Commons\Specie;
use App\Models\Moviments\Conveyor;
use App\Models\Moviments\Moviment;
use App\Models\Moviments\Settings\CalculusTable;
use App\Models\Moviments\Settings\MovimentFreight;
use App\Models\Moviments\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class MovimentController extends Controller {

    public $entity = "moviments";
    public $sex = "M";
    public $name = "Movimento";
    public $names = "Movimentos";
    public $main_folder = 'pages.moviments.moviments';
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
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request) {

	    $moviments = new Moviment();
	    $this->page->response = $this->MovimentFilter->map($request, $moviments);

	    $this->page->auxiliar = [
		    'document_types'    => DocumentType::getAlltoSelectList(),
		    'moviment_freights' => MovimentFreight::getAlltoSelectList(),
		    'partners'          => Conveyor::getAlltoSelectList(),
//		    'commodities'       => Commodity::getAlltoSelectList(),
//		    'species'           => Specie::getAlltoSelectList(),
//		    'calculus_types'    => CalculusType::getAlltoSelectList(),
//		    'modalities'        => Modality::getAlltoSelectList(),
//		    'receivers'         => Receiver::getAlltoSelectList(),
//		    'sender'            => [$data->sender_id => $data->sender->getName()],
//		    'dispatcher'        => [$data->dispatcher_id => $data->dispatcher->getName()],
//		    'payer'             => [$data->payer_id => $data->payer->getName()],
//		    'receiver'          => [$data->receiver_id => $data->receiver->getName()],
	    ];


        $this->page->create_option = 1;
        $this->page->import_option = 1;
        return view('pages.moviments.moviments.index' )
            ->with( 'Page', $this->page );
    }

    /**
     * Create the specified resource.
     *
     *
     * @return Response
     */
    public function create( ) {
        $this->page->auxiliar = [
            'document_types'    => DocumentType::getAlltoSelectList(),
            'commodities'       => Commodity::getAlltoSelectList(),
            'species'           => Specie::getAlltoSelectList(),
            'calculus_types'    => CalculusType::getAlltoSelectList(),
            'modalities'        => Modality::getAlltoSelectList(),
            'receivers'         => Receiver::getAlltoSelectList(),
            'moviment_freights' => MovimentFreight::getAlltoSelectList(),
        ];
        $this->page->import_option = 1;
        return view('pages.moviments.moviments.master' )
            ->with( 'Page', $this->page );
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     *
     * @return Response
     */
    public function edit( $id ) {
        $data = Moviment::findOrFail( $id );
        $this->page->auxiliar = [
            'document_types'    => DocumentType::getAlltoSelectList(),
            'commodities'       => Commodity::getAlltoSelectList(),
            'species'           => Specie::getAlltoSelectList(),
            'calculus_types'    => CalculusType::getAlltoSelectList(),
            'modalities'        => Modality::getAlltoSelectList(),
            'receivers'         => Receiver::getAlltoSelectList(),
            'moviment_freights' => MovimentFreight::getAlltoSelectList(),
            'sender'            => [$data->sender_id => $data->sender->getName()],
            'dispatcher'        => [$data->dispatcher_id => $data->dispatcher->getName()],
            'payer'             => [$data->payer_id => $data->payer->getName()],
            'receiver'          => [$data->receiver_id => $data->receiver->getName()],
        ];
        $this->page->create_option = 1;
        $this->page->import_option = 1;
        return view('pages.moviments.moviments.master' )
            ->with( 'Page', $this->page )
            ->with( 'Data', $data );
    }
    /**
     * Store the specified resource in storage.
     *
     * @param MovimentRequest $request
     *
     * @return Response
     */
    public function store( MovimentRequest $request ) {
        $data = Moviment::create( $request->all() );
        return $this->redirect( 'STORE', $data );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param MovimentRequest $request
     * @param  $id
     *
     * @return Response
     */
    public function update( MovimentRequest $request, $id ) {
        $data = Moviment::findOrFail( $id );
//	    return $data->items;

	    if($data->hasOppenedContracts()){
		    return $this->error( ['Este movimento não pode ser alterado! Existem contratações já fechadas.'] );
	    }

        $data->update( $request->all() );
        return $this->redirect( 'UPDATE', $data );
    }


    /**
     * Import the specified resource in storage.
     *
     * @param MovimentImportRequest $request
     *
     * @return Response
     */
    public function import( MovimentImportRequest $request ) {
        if ( $request->has( 'file_import' ) ) {
//			$file = 'storage/import/COLETAS_IMPORTAR.xls'; //servidor
            $file = $request->file( 'file_import' ); //servidor
            set_time_limit( 3600 );
//            ini_set('memory_limit', '20000M');
//            dd($file);
            $data = array();
            try {
                //some data

                $i = 0;
                Excel::load($file, function ($sheet) use ( &$data, $i ) {

	                $lastrow = $sheet->getActiveSheet()->getHighestRow();
	                if($lastrow > 100000){
		                dd('Message: Número de linhas superior à 100000 ou formato de arquivo inválido!');
	                }
                    // Loop through all sheets
                    $sheet->each(function ($row) use ( &$data, $i ) {
                    	if(!Moviment::whereCtrc($row->ctrc)->exists()){
		                    $m['ctrc'] = $row->ctrc;
		                    $m['cte_number'] = strval($row->numero_ct_e);

		                    //document_type
		                    $rw = DocumentType::whereDescription($row->tipo_do_documento);
		                    if($rw != NULL){
			                    $m['document_type'] = $rw->id;
		                    } else {
			                    dd('Tipo de documento inexistente: "'.$row->tipo_do_documento.'"');
		                    }

		                    //emitted_at
		                    $dt = $row->data_de_emissao;
		                    $hr = $row->hora_de_emissao;
		                    if($dt!=NULL){
			                    $m['emitted_at'] = ($hr != NULL) ? $hr->format('H:i'): '';
			                    $m['emitted_at'] .= ($dt != NULL) ? $dt->format('d/m/Y') : '';
			                    $m['emitted_at'] = preg_replace('/[^0-9]/', '', $m['emitted_at']);
		                    }
//                        dd($m);

		                    $m['cte_key'] = $row->chave_cte;


		                    //sender
		                    $sender = Entity::whereCnpj($row->cnpj_remetente)->first();
		                    if($sender == NULL){
			                    $sender = Entity::import($row, 'sender');
		                    }
		                    $m['sender_id'] = $sender->id;

		                    //dispatcher
		                    $dispatcher = Entity::whereCnpj($row->cnpj_expedidor)->first();
		                    if($dispatcher == NULL){
			                    $dispatcher = Entity::import($row, 'dispatcher');
		                    }
		                    $m['dispatcher_id'] = $dispatcher->id;

		                    //payer
		                    $payer = Entity::whereCnpj($row->cnpj_pagador)->first();
		                    if($payer == NULL){
			                    $payer = Entity::import($row, 'payer');
		                    }
		                    $m['payer_id'] = $payer->id;

		                    //receiver
		                    $receiver = Receiver::whereCnpj($row->cnpj_destinatario)->first();
		                    if($receiver == NULL){
			                    $receiver = Receiver::import($row);
		                    }
		                    $m['receiver_id'] = $receiver->id;
		                    //cadastrar parceiro
//	                    dd($receiver->getConveyourId());
		                    $m['partner_id'] = $receiver->getConveyourId();


		                    $m['destiny_unity'] = $row->unidade_destino;
		                    $m['real_weight'] = $row->peso_real_em_kg;
		                    $m['cubage'] = $row->cubagem_em_m3;
		                    $m['volume_quantity'] = intval($row->quantidade_de_volumes);
		                    $rw = MovimentFreight::whereDescription($row->tipo_do_frete);
		                    if($rw != NULL){
			                    $m['freight'] = $rw->id;
		                    } else {
			                    dd('Tipo de Frete inexistente: "'.$row->tipo_do_frete.'"');
		                    }


		                    //commodity
		                    $mercadoria = trim($row->mercadoria);
		                    $commodity = Commodity::findData($mercadoria);
		                    if($commodity == NULL){
			                    $commodity = Commodity::import($mercadoria);
		                    }
		                    $m['commodity_id'] = $commodity->id;

		                    //specie
		                    $especie = trim($row->especie);
		                    $specie = Specie::findData($especie);
		                    if($specie == NULL){
			                    $specie = Specie::import($especie);
		                    }
		                    $m['specie_id'] = $specie->id;
		                    $m['value']             = $row->valor_da_mercadoria;

		                    $c = CalculusTable::whereDescription($row->tipo_de_calculo);
		                    if($c == NULL){
			                    $m['calculus_type']    = 1; //COTAÇÃO
		                    } else {
			                    $m['calculus_type']    = $c->id;
		                    }

		                    $m['calculus_table']    = $row->tabela_de_calculo;
		                    $m['freight_value']     = $row->valor_do_frete;
		                    $m['freight_icms']      = $row->valor_do_frete_sem_icms;
		                    $m['calculus_basis']    = $row->base_de_calculo;
		                    $m['icms_value']        = $row->valor_do_icms;
		                    $m['aliquot']           = $row->aliquota;
		                    $m['iss_value']         = $row->valor_do_iss;
		                    $m['weight_calculated'] = $row->peso_calculado_em_kg;
		                    $m['weight_freight']    = $row->frete_peso;
		                    $m['value_freight']     = $row->frete_valor;
		                    $m['despatch']          = $row->despacho;
		                    $m['cat']               = $row->cat;
		                    $m['itr']               = $row->itr;
		                    $m['gris']              = $row->gris;
		                    $m['toll']              = $row->pedagio;
		                    $m['tas']               = $row->tas;
		                    $m['tda']               = $row->tda;

		                    $m['suframa']           = $row->suframa;
		                    $m['others']            = $row->outros;
		                    $m['collect']           = $row->coleta;
		                    $m['tdc']               = $row->tdc;
		                    $m['tde']               = $row->tde;
		                    $m['tar']               = $row->tar;

//                        $this->command->info( "****************** (A) ******************");

		                    $m['first_manifest']    = $row->primeiro_manifesto;
		                    //first_manifested_at
		                    $dt = $row->data_do_primeiro_manifesto;
		                    if($dt!=NULL){
//                            $m['first_manifested_at'] = $dt->format('Y-m-d');
			                    $m['first_manifested_at'] = $dt->format('d/m/Y');
		                    }

		                    $m['last_manifest']    = $row->ultimo_manifesto;
		                    //last_manifested_at
		                    $dt = $row->data_do_ultimo_manifesto;
		                    if($dt!=NULL){
//                            $m['last_manifested_at'] = $dt->format('Y-m-d');
			                    $m['last_manifested_at'] = $dt->format('d/m/Y');
		                    }

		                    $m['last_cargo']    = $row->ultimo_romaneio;
		                    //last_manifested_at
		                    $dt = $row->data_do_ultimo_romaneio;
		                    if($dt!=NULL){
//                            $m['last_cargo_at'] = $dt->format('Y-m-d');
			                    $m['last_cargo_at'] = $dt->format('d/m/Y');
		                    }

		                    $m['last_occurrence_code']    = intval(trim($row->codigo_da_ultima_ocorrencia));
		                    //delivery_prevision
		                    $dt = $row->previsao_de_entrega;
		                    if($dt!=NULL){
//                            $m['delivery_prevision'] = $dt->format('Y-m-d');
			                    $m['delivery_prevision'] = $dt->format('d/m/Y');
		                    }

		                    //delivery_prevision
		                    $dt = $row->data_da_entrega_realizada;
		                    if($dt!=NULL){
//                            $m['delivered_at'] = $dt->format('Y-m-d');
			                    $m['delivered_at'] = $dt->format('d/m/Y');
		                    }

		                    //canceled_at
		                    $dt = $row->data_do_cancelamento;
		                    if($dt!=NULL){
//                            $m['canceled_at'] = $dt->format('Y-m-d');
			                    $m['canceled_at'] = $dt->format('d/m/Y');
		                    }

		                    $m['canceled_reason']    = trim(Str::limit($row->motivo_do_cancelamento,  500,""));
		                    $m['request_number']    = trim(Str::limit($row->numero_dos_pedidos, 100,""));

//                        $this->command->info( "****************** (B) ******************");

		                    //horse_id
		                    $vehicle = Vehicle::getOrCreate($row->placa_do_cavalo);
		                    $m['horse_id'] = optional($vehicle)->id;
//                        $this->command->info( "****************** (C) ******************");

		                    //cart_id
		                    $vehicle = Vehicle::getOrCreate($row->placa_da_carreta);
		                    $m['cart_id'] = optional($vehicle)->id;

		                    //deliver_id
		                    $vehicle = Vehicle::getOrCreate($row->placa_de_entrega);
		                    $m['deliver_id'] = optional($vehicle)->id;

		                    //modality_id
		                    if($row->modalidade != NULL){
			                    $modality = Modality::whereDescription($row->modalidade)->first();
			                    if($modality == NULL){
				                    $modality = Modality::create([
					                    'description' =>$row->modalidade
				                    ]);
			                    }
			                    $m['modality_id'] = $modality->id;
		                    }

//                        $data[] = $m;
		                    Moviment::_create($m, $row->notas_fiscais);
	                    }
                    });
                })->ignoreEmpty();

                return response()->success( $this->getMessageFront( 'IMPORT' ), [], route( $this->entity . '.index' ) );
            }  catch(Exception $e) {
                $error = 'Message: ' .$e->getMessage();
                die($error . "\n");
            }

        } else {
            return view( 'pages.moviments.moviments.create-import' )
                ->with( 'Page', $this->page );
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( $id ) {
        $vechicle = Moviment::find($id);
        $message = $this->getMessageFront( 'DELETE', $this->name . ': ' . $vechicle->getShortName() );
        return new JsonResponse( [
            'status'  => $vechicle->delete(),
            'message' => $message,
        ], 200 );
    }
}
