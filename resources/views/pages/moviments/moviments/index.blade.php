@extends('layout.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layout.inc.defaultsubmenu',['entity'=>$Page->entity])

@endsection

@section('page_content')
    <!-- Main container -->

    <div class="main-content">


        @include('layout.inc.alerts')
        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Filter row
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">
            <header class="card-header">
                <h4 class="card-title">Filtros</h4>
                <ul class="card-controls">
                    <li><a class="card-btn-slide" href="#"></a></li>
                </ul>
            </header>
            <div class="card-content">
                <div class="card-body">

                    {!! Form::open(['route' => 'moviments.index',
                        'method' => 'GET']) !!}
                        {{--<div class="form-row">--}}
                            {{--<div class="form-group col-md-12">--}}
                                {{--{!! Html::decode(Form::label('emitted_at_start', 'Data de Emissão', array('class' => 'col-form-label'))) !!}--}}
                                {{--{{Form::select('emitted_at_start', [], old('emitted_at_start', Request::get('emitted_at_start')), ['id'=>'emitted_at_start','placeholder' => 'Data de Emissão', 'class'=>'form-control'])}}--}}
                                {{--<div class="invalid-feedback"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-row">
                            <div class="col-md-12">
                                <hr class="d-lg-none">
                                <h6>Período</h6>

                                <div class="col-md-12">
                                    <div class="form-check form-check-inline mr-40">
                                        <input class="form-check-input" type="radio" name="period" value="1" @if((!Request::has('period')) || (Request::get('period') == 1)) checked="" @endif>
                                        <label class="form-check-label" for="inlineRadio1">Hoje</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-40">
                                        <input class="form-check-input" type="radio" name="period" value="2" @if((Request::get('period') == 2)) checked="" @endif>
                                        <label class="form-check-label" for="inlineRadio1">Ontem</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-40">
                                        <input class="form-check-input" type="radio" name="period" value="3" @if((Request::get('period') == 3)) checked="" @endif>
                                        <label class="form-check-label" for="inlineRadio2">Última Semana</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-40">
                                        <input class="form-check-input" type="radio" name="period" value="4" @if((Request::get('period') == 4)) checked="" @endif>
                                        <label class="form-check-label" for="inlineRadio3">Este Mês</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-50">
                                        <input class="form-check-input" type="radio" name="period" value="5" @if((Request::get('period') == 5)) checked="" @endif>
                                        <label class="form-check-label mr-20" for="inlineRadio3">Especificar: </label>
                                        {{Form::text('emitted_at', old('emitted_at', (Request::get('period') == 5) ? Request::get('emitted_at') :""),['placeholder'=>'Data', 'class'=>'form-control show-date'])}}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-sm mb-2">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('ctrc', 'CTRT', array('class' => 'col-form-label'))) !!}
                                {{Form::text('ctrc', old('ctrc',Request::get('ctrc')), ['placeholder'=>'CTRC','class'=>'form-control', 'maxlength'=>'20'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('cte_number', 'Número CT-e', array('class' => 'col-form-label'))) !!}
                                {{Form::text('cte_number', old('cte_number',Request::get('cte_number')), ['placeholder'=>'Número CT-e','class'=>'form-control', 'maxlength'=>'20'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('moviment_freight', 'Tipo Frete', array('class' => 'col-form-label'))) !!}
                                {{Form::select('moviment_freight', $Page->auxiliar['moviment_freights'], old('moviment_freight', Request::get('moviment_freight')), ['placeholder' => 'Tipo Frete', 'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('document_type', 'Tipo Documento', array('class' => 'col-form-label'))) !!}
                                {{Form::select('document_type', $Page->auxiliar['document_types'], old('document_type', Request::get('document_type')), ['placeholder' => 'Tipo Documento', 'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('sender', 'Remetente', array('class' => 'col-form-label'))) !!}
                                {{Form::text('sender', old('sender',Request::get('sender')), ['placeholder'=>'Remetente','class'=>'form-control', 'maxlength'=>'100'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('receiver', 'Destinatário', array('class' => 'col-form-label'))) !!}
                                {{Form::text('receiver', old('receiver',Request::get('receiver')), ['placeholder'=>'Destinatário','class'=>'form-control', 'maxlength'=>'100'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('payer', 'Pagador', array('class' => 'col-form-label'))) !!}
                                {{Form::text('payer', old('payer',Request::get('payer')), ['placeholder'=>'Pagador','class'=>'form-control', 'maxlength'=>'100'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('fiscal_number', 'Nota Fiscal', array('class' => 'col-form-label'))) !!}
                                {{Form::text('fiscal_number', old('fiscal_number',Request::get('fiscal_number')), ['placeholder'=>'Nota Fiscal','class'=>'form-control', 'maxlength'=>'20'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('destiny_unity', 'Unidade Destino', array('class' => 'col-form-label'))) !!}
                                {{Form::text('destiny_unity', old('destiny_unity',Request::get('destiny_unity')), ['placeholder'=>'Unidade Destino','class'=>'form-control', 'maxlength'=>'100'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Html::decode(Form::label('partner_id', 'Parceiro', array('class' => 'col-form-label'))) !!}
                                {{Form::select('partner_id', $Page->auxiliar['partners'], old('partner_id', Request::get('partner_id')), ['placeholder' => 'Parceiro', 'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary" name="search" type="submit"><i class="ti-search"></i> Filtrar</button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">
            <h4 class="card-title"><strong>{{count($Page->response)}}</strong> {{$Page->names}}</h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Data Emissão</th>
                            <th>CTRC</th>
                            <th>CTE</th>
                            <th>Cnpj Remetente</th>
                            <th>Remetente</th>
                            <th>Cnpj Destinatário</th>
                            <th>Destinatário</th>
                            <th>Cnpj Pagador</th>
                            <th>Pagador</th>
                            <th>Notas</th>
                            <th>Qtd Volumes</th>
                            <th>Peso Calculado</th>
                            <th>Val. Mercadoria</th>
                            <th>Tipo Frete</th>
                            <th>Tipo Documento</th>
                            <th>Alíquota ICMS</th>
                            <th>Valor ICMS</th>
                            <th>Valor Frete</th>
                            <th>Valor Frete sem ICMS</th>
                            <th>Unidade Destino</th>
                            <th>Parceiro</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Data Emissão</th>
                            <th>CTRC</th>
                            <th>CTE</th>
                            <th>Cnpj Remetente</th>
                            <th>Remetente</th>
                            <th>Cnpj Destinatário</th>
                            <th>Destinatário</th>
                            <th>Cnpj Pagador</th>
                            <th>Pagador</th>

                            <th>Notas</th>
                            <th>Qtd Volumes</th>
                            <th>Peso Calculado</th>
                            <th>Val. Mercadoria</th>
                            <th>Tipo Frete</th>
                            <th>Tipo Documento</th>
                            <th>Alíquota</th>
                            <th>Valor ICMS</th>
                            <th>Valor Frete</th>
                            <th>Valor Frete sem ICMS</th>
                            <th>Unidade Destino</th>
                            <th>Parceiro</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr>
                                <td>
                                    @include('layout.inc.buttons.edit')
                                    {{--                                    @include('layout.inc.buttons.delete')--}}
                                </td>
                                <td>{{$sel['id']}}</td>
                                <td>{{$sel['emitted_at_formatted']}}</td>
                                <td>{{$sel['ctrc']}}</td>
                                <td>{{$sel['cte_number']}}</td>
                                <td>{{$sel['sender_document']}}</td>
                                <td>{{$sel['sender_text']}}</td>
                                <td>{{$sel['receiver_document']}}</td>
                                <td>{{$sel['receiver_text']}}</td>
                                <td>{{$sel['payer_document']}}</td>
                                <td>{{$sel['payer_text']}}</td>
                                <td>{{$sel['nfs']}}</td>
                                <td>{{$sel['volume_quantity']}}</td>
                                <td>{{$sel['weight_calculated_formatted']}}</td>
                                <td>R$ {{$sel['value_formatted']}}</td>
                                <td>{{$sel['freight_text']}}</td>
                                <td>{{$sel['document_type_text']}}</td>
                                <td>{{$sel['aliquot_formatted']}} %</td>
                                <td>R$ {{$sel['icms_value_formatted']}}</td>
                                <td>R$ {{$sel['freight_value_formatted']}}</td>
                                <td>R$ {{$sel['freight_icms_formatted']}}</td>

                                <td>{{$sel['destiny_unity']}}</td>
                                <td>{{$sel['partner_text']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('layout.inc.loading')
        </div>


    </div><!--/.main-content -->
@endsection


@section('script_content')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layout.inc.datatable.js')

    @include('layout.inc.sweetalert.js')

    <!-- Jquery InputMask Js -->
    @include('layout.inc.inputmask.js')
@endsection
