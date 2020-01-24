<?php

return [

    'cost_types' => [
        ['id' => '1','description'=>'CUSTO COLETA'],
        ['id' => '2','description'=>'CUSTO EXTRA COLETA'],
        ['id' => '3','description'=>'CUSTO TRANSFERÊNCIA'],
        ['id' => '4','description'=>'CUSTO EMBARQUE'],
        ['id' => '5','description'=>'CUSTO ENTREGA'],
        ['id' => '6','description'=>'CUSTO EXTRA'],
    ],

    'contract_types' => [
        ['id' => '1','description'=>'FIXO'],
        ['id' => '2','description'=>'ESPORÁDICO'],
    ],

    'contract_partner_types' => [
        ['id' => '1','description'=>'VEÍCULO'],
        ['id' => '2','description'=>'TRANSPORTADORA'],
    ],

    'vehicle_types' => [
        ['id' => '1','description'=>'FIORINO'],
        ['id' => '2','description'=>'HR'],
        ['id' => '3','description'=>'VUC'],
        ['id' => '4','description'=>'3,4'],
        ['id' => '5','description'=>'TOCO'],
        ['id' => '6','description'=>'TRUCK'],
        ['id' => '7','description'=>'BI-TRUCK'],
        ['id' => '8','description'=>'CARRETA'],
        ['id' => '9','description'=>'BI-TREM'],
        ['id' => '10','description'=>'OUTRO'],
    ],

    'bodywork_types' => [
        ['id' => '1','description'=>'ABERTA'],
        ['id' => '2','description'=>'BAÚ'],
        ['id' => '3','description'=>'CAÇAMBA'],
        ['id' => '4','description'=>'BAÚ PLATAFORMA'],
        ['id' => '5','description'=>'MUNK'],
        ['id' => '6','description'=>'OUTRO'],
    ],

    'priority_types' => [
        ['id' => '1','description'=>'A'],
        ['id' => '2','description'=>'B'],
        ['id' => '3','description'=>'C'],
        ['id' => '4','description'=>'D'],
        ['id' => '5','description'=>'E'],
    ],

    'price_types' => [
        ['id' => '1','description'=>'Tabela frete peso c/ faixa de  até 100 kg e excedente'],
        ['id' => '2','description'=>'Tabela frete peso c/ faixa de até 30 kg e excedente'],
        ['id' => '3','description'=>'Tabela frete peso c/ taxa fixa e excendente'],
        ['id' => '4','description'=>'Tabela % Sobre o valor do CT-e'],
        ['id' => '5','description'=>'Tabela % Sobre o valor da NF'],
    ],

    'generalities' => [
        ['id' => '1','min'=>false,'type'=>'percent','description'=>'Ad-valorem'],
        ['id' => '2','min'=>false,'type'=>'money','description'=>'Após as 18:00'],
        ['id' => '3','min'=>false,'type'=>'money','description'=>'Armazenagem'],
        ['id' => '4','min'=>false,'type'=>'money','description'=>'Carga e descarga'],
        ['id' => '5','min'=>false,'type'=>'money','description'=>'Carro dedicado'],

        ['id' => '6','min'=>false,'type'=>'money','description'=>'Comprovante de Entrega'],
        ['id' => '7','min'=>false,'type'=>'percent','description'=>'Devolução'],
        ['id' => '8','min'=>false,'type'=>'money','description'=>'Escolta'],
        ['id' => '9','min'=>false,'type'=>'money','description'=>'Finais de semana'],
        ['id' => '10','min'=>true,'type'=>'percent','description'=>'Gris'],
        ['id' => '11','min'=>false,'type'=>'money','description'=>'Movimentação com empilhadeira'],
        ['id' => '12','min'=>false,'type'=>'money','description'=>'Paletização'],
        ['id' => '13','min'=>false,'type'=>'money','description'=>'Pedágio'],
        ['id' => '14','min'=>false,'type'=>'money','description'=>'Redespacho'],
        ['id' => '15','min'=>false,'type'=>'percent','description'=>'Reentrega'],
        ['id' => '16','min'=>false,'type'=>'money','description'=>'Shoppings e Aeroportos'],
        ['id' => '17','min'=>false,'type'=>'money','description'=>'TAS'],
        ['id' => '18','min'=>false,'type'=>'money','description'=>'Taxa de Carga/Descarga'],
        ['id' => '19','min'=>false,'type'=>'money','description'=>'Taxa de Coleta'],
        ['id' => '20','min'=>false,'type'=>'money','description'=>'Taxa de Embalagem'],
        ['id' => '21','min'=>false,'type'=>'money','description'=>'Taxa de Emissão'],
        ['id' => '22','min'=>false,'type'=>'money','description'=>'Taxa de Entrega'],
        ['id' => '23','min'=>false,'type'=>'money','description'=>'Taxa Sefaz e Suframa'],
        ['id' => '24','min'=>true,'type'=>'money','description'=>'TDE'],
        ['id' => '25','min'=>false,'type'=>'money','description'=>'Tempo máximo de espera'],
        ['id' => '26','min'=>false,'type'=>'money','description'=>'TRT'],
        ['id' => '27','min'=>false,'type'=>'money','description'=>'Veículo Munk'],
    ],

    'document_types' => [
	    ['id' => '1','description'=>'REVERSA'],
	    ['id' => '2','description'=>'NORMAL'],
	    ['id' => '3','description'=>'CARGA FECHADA'],
	    ['id' => '4','description'=>'COMPLEMENTAR FRETE'],
	    ['id' => '5','description'=>'PRES SERVICO'],

	    ['id' => '6','description'=>'CORTESIA'],
	    ['id' => '7','description'=>'SUBC FEC FORM CTRC'],
	    ['id' => '8','description'=>'SUBC FORM CTRC'],
	    ['id' => '9','description'=>'DEVOLUCAO'],
    ],

    'moviment_freights' => [
	    ['id' => '0','description'=>'FP'],
	    ['id' => '1','description'=>'CP'],

	    ['id' => '2','description'=>'CV'],
    ],

    'calculus_types' => [
	    ['id' => '1','description'=>'COTAÇÃO'],
	    ['id' => '2','description'=>'COMBINADA'],
	    ['id' => '3','description'=>'INFORMADO'],
	    ['id' => '4','description'=>'PERCENTUAL'],
    ],

];
