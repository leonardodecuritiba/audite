<?php

use Illuminate\Database\Seeder;
use App\Models\Moviments\Moviment;
use App\Models\Moviments\Commons\DocumentType;
use App\Models\Moviments\Commons\Entity;
use App\Models\Moviments\Commons\Receiver;
use App\Models\HumanResources\Settings\Address;
use App\Models\Moviments\Settings\MovimentFreight;
use App\Models\Moviments\Settings\CalculusTable;
use App\Models\Moviments\Commons\Modality;
use App\Models\Moviments\Commons\Commodity;
use App\Models\Moviments\Commons\Specie;
use App\Models\Moviments\Commons\Invoice;
use App\Models\Moviments\Vehicle;

class ImportMovimentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    //php artisan db:seed --class=ImportMovimentSeeder
	    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

	    Moviment::truncate();

	    Entity::flushEventListeners();
	    Entity::getEventDispatcher();
	    Entity::truncate();

	    Receiver::flushEventListeners();
	    Receiver::getEventDispatcher();
	    Receiver::truncate();

	    Address::flushEventListeners();
	    Address::getEventDispatcher();
	    Address::truncate();

	    Commodity::flushEventListeners();
	    Commodity::getEventDispatcher();
	    Commodity::truncate();

	    Specie::flushEventListeners();
	    Specie::getEventDispatcher();
	    Specie::truncate();

	    Vehicle::flushEventListeners();
	    Vehicle::getEventDispatcher();
	    Vehicle::truncate();

	    Modality::flushEventListeners();
	    Modality::getEventDispatcher();
	    Modality::truncate();

	    Invoice::flushEventListeners();
	    Invoice::getEventDispatcher();
	    Invoice::truncate();

	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

	    $this->command->info( '* Import Moviments' );
	    $start = microtime(true);

	    $filename = 'moviments_resumed.xls';
	    $filename = 'moviments.xlsx';

	    $this->command->info( "*** Iniciando o Upload ***");
	    $file = storage_path('imports' . DIRECTORY_SEPARATOR . $filename);

	    set_time_limit(3600);


	    $reader = Excel::load($file, function ($sheet) {
		    // Loop through all sheets
		    $sheet->each(function ($row) {

		    	$m['ctrc'] = $row->ctrc;
		    	$m['cte_number'] = strval($row->numero_ct_e);

		    	//document_type
			    $rw = DocumentType::whereDescription($row->tipo_do_documento);
			    if($rw != NULL){
				    $m['document_type'] = $rw->id;
			    }

		    	//emitted_at
		    	$dt = $row->data_de_emissao;
		    	$hr = $row->hora_de_emissao;
		    	if($dt!=NULL){
				    $m['emitted_at'] = $dt->format('Y-m-d') . (($hr != NULL) ? ' ' . $hr->format('H:i:s') : '');
			    }

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

			    $m['real_weight'] = $row->peso_real_em_kg;
			    $m['cubage'] = $row->cubagem_em_m3;
			    $m['volume_quantity'] = intval($row->quantidade_de_volumes);
			    $m['freight'] = MovimentFreight::whereDescription($row->tipo_do_frete)->id;


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


			    $this->command->info( "****************** (A) ******************");


			    $m['first_manifest']    = $row->primeiro_manifesto;
			    //first_manifested_at
			    $dt = $row->data_do_primeiro_manifesto;
			    if($dt!=NULL){
				    $m['first_manifested_at'] = $dt->format('Y-m-d');
			    }

			    $m['last_manifest']    = $row->ultimo_manifesto;
			    //last_manifested_at
			    $dt = $row->data_do_ultimo_manifesto;
			    if($dt!=NULL){
				    $m['last_manifested_at'] = $dt->format('Y-m-d');
			    }

			    $m['last_cargo']    = $row->ultimo_romaneio;
			    //last_manifested_at
			    $dt = $row->data_do_ultimo_romaneio;
			    if($dt!=NULL){
				    $m['last_cargo_at'] = $dt->format('Y-m-d');
			    }

			    $m['last_occurrence_code']    = intval(trim($row->codigo_da_ultima_ocorrencia));
			    //delivery_prevision
			    $dt = $row->previsao_de_entrega;
			    if($dt!=NULL){
				    $m['delivery_prevision'] = $dt->format('Y-m-d');
			    }

			    //delivery_prevision
			    $dt = $row->data_da_entrega_realizada;
			    if($dt!=NULL){
				    $m['delivered_at'] = $dt->format('Y-m-d');
			    }

			    //canceled_at
			    $dt = $row->data_do_cancelamento;
			    if($dt!=NULL){
				    $m['canceled_at'] = $dt->format('Y-m-d');
			    }

			    $m['canceled_reason']    = trim($row->motivo_do_cancelamento);
			    $m['request_number']    = trim($row->numero_dos_pedidos);

			    $this->command->info( "****************** (B) ******************");

				//horse_id
			    if($row->placa_do_cavalo != NULL){
				    $vehicle = Vehicle::wherePlate($row->placa_do_cavalo)->first();
				    if($vehicle == NULL){
					    $vehicle = Vehicle::create([
					    	'plate' =>$row->placa_do_cavalo
					    ]);
				    }
				    $m['horse_id'] = $vehicle->id;
			    }

			    $this->command->info( "****************** (C) ******************");

			    //cart_id
			    if($row->placa_da_carreta != NULL){
				    $vehicle = Vehicle::wherePlate($row->placa_da_carreta)->first();
				    if($vehicle == NULL){
					    $vehicle = Vehicle::create([
					    	'plate' =>$row->placa_da_carreta
					    ]);
				    }
				    $m['cart_id'] = $vehicle->id;
			    }

			    //deliver_id
			    if($row->placa_de_entrega != NULL){
				    $vehicle = Vehicle::wherePlate($row->placa_de_entrega)->first();
				    if($vehicle == NULL){
					    $vehicle = Vehicle::create([
						    'plate' =>$row->placa_de_entrega
					    ]);
				    }
				    $m['deliver_id'] = $vehicle->id;
			    }

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

			    $moviment = Moviment::_create($m, $row->notas_fiscais);
			    $this->command->alert(  $moviment->id );

		    });
	    })->ignoreEmpty();

	    $this->command->alert( 'Import FINISHED in ' . round((microtime(true) - $start), 3) . "s ***");

    }
}
