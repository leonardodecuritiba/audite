<?php

namespace App\Helpers;

use App\Models\Transactions\Apparatu;
use App\Models\Empresa;
use App\Models\Transactions\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use \Barryvdh\DomPDF\Facade as PDF;

class PrintHelper
{
    private $linha_xls;
    private $data;
    private $insumos;
    private $outros_custos;
    private $Order;

    // ******************** FUNCTIONS ******************************
    public function exportOS(Order $order)
    {

	    $Empresa = new Empresa();
//        incluir no cabeçalho ou rodapé seguinte observaçao: .
        $this->Order = $order;
        $Cliente = $this->Order->cliente;
        $filename = 'Order_' . $this->Order->idordem_servico . '_' . Carbon::now()->format('H-i_d-m-Y');

        $atlas = array(
            'endereco' => 'Rua Triunfo, 400',
            'bairro'        => $Empresa->bairro,
            'cidade'        => $Empresa->cidade,
            'cep'           => $Empresa->cep,
            'cnpj'          => $Empresa->cnpjFormatted(),
            'razao_social'  => $Empresa->razao_social,
            'ie'            => $Empresa->ieFormatted(),
            'n_autorizacao' => $Empresa->n_autorizacao,
            'fone'          => $Empresa->getPhoneAndCellPhone(),//'(16)3011-8448',
            'email'         => $Empresa->email_os);//'os@atlastecnologia.com.br');
        $empresa = array(
            'nome' => 'ORDEM DE SERVIÇO - #' . $this->Order->idordem_servico,
            'descricao' => 'Manutenção e venda de equipamentos de automação comercial',
            'dados' => $atlas,
            'logo' => public_path('uploads/institucional/logo_atlas.png'),
        );

        $aviso_txt = [
            [
                'ASSINATURA:',
                'O CLIENTE CONFIRMA A EXECUÇÃO DOS SERVIÇOS E TROCA DE PEÇAS ACIMA CITADOS, E TAMBÉM APROVA OS PREÇOS COBRADOS.'],
            [
                'EQUIPAMENTOS DEIXADOS POR CLIENTES NA EMPRESA:',
                'O CLIENTE AUTORIZA PRÉVIA E EXPRESSAMANTE UMA VEZ QUE ORÇAMENTOS NÃO FOREM APROVADOS QUE INSTRUMENTOS OU EQUIPAMANTOS NÃO ',
                'RETIRADOS DAS DEPENDÊCIAS DA EMPRESA NO PRAZO DE 90 DIAS DA ASSINATURA DESSA ORDEM SERVIÇO SEJAM DESCARTADOS PARA O LIXO OU SUCATA.'
            ]
        ];

        if ($this->Order->status() == 0) {
            $aviso_txt[] = ['Ordem serviço não finalizada'];
        }

        if ($Cliente->is_pjuridica()) {
            //empresa
            $Pessoa_juridica = $Cliente->pessoa_juridica;
            $Contato = $Cliente->contato;

            $dados_cliente = [
                array(
                    'Cliente / Razão Social:', $Pessoa_juridica->razao_social,
                    'Fantasia:', $Pessoa_juridica->nome_fantasia,
                    'HR / DATA I', $this->Order->created_at
                ),
                array(
                    'CNPJ:', $Pessoa_juridica->cnpj,
                    'I.E:', $Pessoa_juridica->ie,
                    'DATA / HR F', $this->Order->data_finalizada
                ),
                array(
                    'Endereço:', $Contato->getRua(),
                    'CEP: ' . $Contato->cep, 'UF: ' . $Contato->estado,
                    'Cidade: ' . $Contato->cidade
                ),
                array(
                    'Telefone:', $Contato->telefone,
                    'Contato:', $Cliente->nome_responsavel
                ),
                array(
                    'Email:', $Cliente->email_nota,
                    'Nº Chamado Sist. Cliente:', $this->Order->numero_chamado
                ),
            ];
        } else {
            $PessoaFisica = $Cliente->pessoa_fisica;
            $Contato = $Cliente->contato;

            $dados_cliente = [
                array(
                    'Cliente / Razão Social:', $Cliente->nome_responsavel,
                    'Fantasia:', '-',
                    'HR / DATA I', $this->Order->created_at
                ),
                array(
                    'CPF:', $PessoaFisica->cpf,
                    'I.E:', '-',
                    'DATA / HR F', $this->Order->data_finalizada
                ),
                array(
                    'Endereço:', $Contato->getRua(),
                    'CEP: ' . $Contato->cep, 'UF: ' . $Contato->estado,
                    'Cidade: ' . $Contato->cidade
                ),
                array(
                    'Telefone:', $Contato->telefone,
                    'Contato:', $Cliente->nome_responsavel
                ),
                array(
                    'Email:', $Cliente->email_nota,
                    'Nº Chamado Sist. Cliente:', $this->Order->numero_chamado
                ),
            ];
        }
        $default_size = '13';
        $font = [
            'nome' => array(
                'family' => 'Bookman Old Style',
                'size' => '16',
            ),
            'descricao' => array(
                'size' => $default_size,
                'bold' => true
            ),
            'endereco' => array(
                'size' => $default_size,
            ),
            'quebra' => array(
                'size' => $default_size,
                'bold' => true
            ),
            'negrito' => array(
                'size' => $default_size,
                'bold' => true
            ),
            'normal' => array(
                'size' => $default_size,
            )
        ];


        $this->data = [
            'empresa' => $empresa,
            'dados_cliente' => $dados_cliente,
            'aviso_txt' => $aviso_txt,
            'fonts' => $font
        ];

        Excel::create($filename, function ($excel) {

//            dd($data['empresa']['cabecalho']);
            $excel->sheet('Sheetname', function ($sheet) {
                $sheet->setPageMargin(0.25);

                $cabecalho = $this->data['empresa']['dados'];

                $sheet->mergeCells('A1:C1');
                $sheet->mergeCells('A2:C2');

                $sheet->cell('A1', function ($cell) {
                    // manipulate the cell
                    $cell->setValue(strtoupper($this->data['empresa']['nome']));
                    $cell->setFont($this->data['fonts']['nome']);
                    $cell->setFontFamily('Bookman Old Style');
                });
                $sheet->cell('A2', function ($cell) {
                    // manipulate the cell
                    $cell->setValue($this->data['empresa']['descricao']);
                    $cell->setFont($this->data['fonts']['descricao']);
                });

                $sheet->rows(array(
                    array($cabecalho['razao_social'] . ' / CNPJ: ' . $cabecalho['cnpj']),
                    array('I.E: ' . $cabecalho['ie']),
                    array('N° de Autorização: ' . $cabecalho['n_autorizacao']),
                    array($cabecalho['endereco'] . ' - ' . $cabecalho['bairro'] . ' - CEP: ' . $cabecalho['bairro']),
                    array('Fone: ' . $cabecalho['fone']),
                    array('E-mail: ' . $cabecalho['email']),
                ));
                $sheet->mergeCells('A3:C3');
                $sheet->mergeCells('A4:C4');
                $sheet->mergeCells('A5:C5');
                $sheet->mergeCells('A6:C6');
                $sheet->mergeCells('A7:C7');
                $sheet->mergeCells('A8:C8');
                $sheet->cells('A3:B8', function ($cells) {
                    // manipulate the range of cells
                    $cells->setFont($this->data['fonts']['endereco']);
                });

                $sheet->mergeCells('D1:G8');
                $objDrawing = new \PHPExcel_Worksheet_Drawing();
                $objDrawing->setPath($this->data['empresa']['logo']); //your image path
                $objDrawing->setCoordinates('D1');
                $objDrawing->setWorksheet($sheet);


                //QUEBRA -------------------------------------------------------------------------------
                //********************************************************************************************//
                //********************************************************************************************//
                $this->linha_xls = 9;
                $info = ['Ordem Serviço n° ' . $this->Order->idordem_servico];
                $sheet->mergeCells('A' . $this->linha_xls . ':G' . $this->linha_xls);
                $sheet->row($this->linha_xls, function ($row) {
                    // call cell manipulation methods
                    $row->setBackground('#d9d9d9');
                    $row->setAlignment('center');
                    $row->setFont($this->data['fonts']['quebra']);
                });
                $sheet->row($this->linha_xls, $info);
                $this->linha_xls++;
                //\QUEBRA ------------------------------------------

                //CABEÇALHO DADOS CLIENTE
                $sheet->rows($this->data['dados_cliente']);
                $this->linha_xls += 6;

                //********************************************************************************************//
                //INSTRUMENTOS ------------------------------------------
                $AparelhosManutencao = $this->Order->aparelho_manutencaos;
                $this->insumos = NULL;
                foreach ($AparelhosManutencao as $Aparelho) {
                    if ($Aparelho->idinstrumento == NULL) {
                        $sheet = $this->setEquipamento($Aparelho, $sheet);
                    } else {
                        $sheet = $this->setInstrumento($Aparelho, $sheet);
                    }

                    //************************** SERVIÇOS ********************************************************//
                    $sheet = $this->setServico($sheet, $Aparelho);
                    //************************** PEÇAS ***********************************************************//
                    $sheet = $this->setPeca($sheet, $Aparelho);
                }

                //********************************************************************************************//
                //************************** FECHAMENTO ******************************************************//
//                $Fechamento = json_decode($this->Order->getValores());
                $this->insumos['total_servicos'] = $this->Order->fechamentoServicosTotalReal();
                $this->insumos['total_pecas'] = $this->Order->fechamentoPecasTotalReal();
                $this->insumos['total_kits'] = $this->Order->fechamentoKitsTotalReal();
                $this->insumos['descontos'] = $this->Order->getDescontoTecnicoReal();
                $this->insumos['acrescimos'] = $this->Order->getAcrescimoTecnicoReal();
                $sheet = $this->setFechamento($sheet);

                //********************************************************************************************//
                //************************* FECHAMENTO FINAL *********************************************//
                $sheet->row($this->linha_xls, function ($row) {
                    $row->setFontWeight(true);
                });
                $sheet->row($this->linha_xls, ['TOTAL  DA ORDEM SERVIÇO', '', '', '', $this->Order->getValorFinalReal()]);
                $this->linha_xls += 2;


                $sheet = self::setCabecalhoCinza($sheet, [
                    'line' => $this->linha_xls,
                    'info' => ['Termos'],
                ]);
                $sheet->mergeCells('A' . $this->linha_xls . ':G' . $this->linha_xls);
                $sheet->row($this->linha_xls, [$this->data['aviso_txt'][0][0]]);
                $this->linha_xls++;
                $sheet->mergeCells('A' . $this->linha_xls . ':G' . $this->linha_xls);
                $sheet->row($this->linha_xls, [$this->data['aviso_txt'][0][1]]);
                $this->linha_xls++;

                $sheet->mergeCells('A' . $this->linha_xls . ':G' . ($this->linha_xls));
                $sheet->row($this->linha_xls, [$this->data['aviso_txt'][1][0]]);
                $this->linha_xls++;
                $sheet->mergeCells('A' . $this->linha_xls . ':G' . ($this->linha_xls));
                $sheet->row($this->linha_xls, [$this->data['aviso_txt'][1][1]]);
                $this->linha_xls++;
                $sheet->mergeCells('A' . $this->linha_xls . ':G' . ($this->linha_xls));
                $sheet->row($this->linha_xls, [$this->data['aviso_txt'][1][2]]);
                $this->linha_xls += 2;

                $sheet = self::setCabecalhoCinza($sheet, [
                    'line' => $this->linha_xls,
                    'info' => ['TÉCNICO'],
                ]);
                $sheet->row($this->linha_xls, [
                    'Nome:', $this->Order->colaborador->nome,
                    'CPF:', $this->Order->colaborador->cpf]);
                $this->linha_xls += 2;
                $sheet->mergeCells('B' . $this->linha_xls . ':G' . ($this->linha_xls));
                $sheet->row($this->linha_xls, ['ASSINATURA :', '________________________________________________________________________________']);
                $this->linha_xls += 2;

                $sheet = self::setCabecalhoCinza($sheet, [
                    'line' => $this->linha_xls,
                    'info' => ['RESPONSÁVEL DO ESTABELECIMENTO'],
                ]);
                $sheet->row($this->linha_xls, [
                    'Nome:', $this->Order->responsavel,
                    'CPF:', $this->Order->responsavel_cpf]);
                $this->linha_xls += 2;
                $sheet->mergeCells('B' . $this->linha_xls . ':G' . ($this->linha_xls));
                $sheet->row($this->linha_xls, ['ASSINATURA :', '________________________________________________________________________________']);
                $this->linha_xls += 2;

                if (isset($this->data['aviso_txt'][2])) {
                    $this->linha_xls++;
                    $sheet->mergeCells('A' . $this->linha_xls . ':G' . ($this->linha_xls));
                    $sheet->row($this->linha_xls, function ($row) {
                        // call cell manipulation methods
                        $row->setBackground('#d9d9d9');
                        $row->setAlignment('center');
                        $row->setFont($this->data['fonts']['quebra']);
                    });
                    $sheet->row($this->linha_xls, $this->data['aviso_txt'][2]);

                }
            });

        })->export('xls');
        return 'imprimir';
    }


}
