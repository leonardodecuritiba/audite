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

                    {!! Form::open(['route' => 'contracts.index',
                        'method' => 'GET']) !!}
                        <div class="form-row">

                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('status', 'Status', array('class' => 'col-form-label'))) !!}
                                {{Form::select('status', $Page->auxiliar['status'], old('status', Request::get('status')), ['placeholder' => 'Todos', 'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('cost_type', 'Tipo de Custo', array('class' => 'col-form-label'))) !!}
                                {{Form::select('cost_type', $Page->auxiliar['cost_types'], old('cost_type', Request::get('cost_type')), ['placeholder' => 'Todos', 'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('contract_partner_type', 'Tipo de Contrato', array('class' => 'col-form-label'))) !!}
                                {{Form::select('contract_partner_type', $Page->auxiliar['contract_partner_types'], '', ['placeholder' => 'Todos', 'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('partner_id', 'Fornecedor', array('class' => 'col-form-label'))) !!}
                                {{Form::select('partner_id', [], '', ['placeholder' => 'Todos', 'class'=>'form-control'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('start_at', 'Data Inicial', array('class' => 'col-form-label'))) !!}
                                {{Form::text('start_at', old('start_at', Request::get('start_at')), ['placeholder'=>'Data Inicial','class'=>'form-control show-date'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('end_at', 'Data Final', array('class' => 'col-form-label'))) !!}
                                {{Form::text('end_at', old('end_at', Request::get('end_at')), ['placeholder'=>'Data Final','class'=>'form-control show-date'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('start_value', 'Valor Inicial', array('class' => 'col-form-label'))) !!}
                                {{Form::text('start_value', old('start_value', Request::get('start_value')), ['placeholder'=>'Valor Inicial','class'=>'form-control show-price'])}}
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group col-md-3">
                                {!! Html::decode(Form::label('end_value', 'Valor Final', array('class' => 'col-form-label'))) !!}
                                {{Form::text('end_value', old('end_value', Request::get('end_value')), ['placeholder'=>'Valor Final','class'=>'form-control show-price'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary" name="search" type="submit"><i class="ti-search"></i> Filtrar</button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
            @include('layout.inc.loading')
        </div>
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
                            <th>ID</th>
                            <th>Status</th>
                            <th>Cadastrado</th>
                            <th>Descrição</th>
                            <th>Tipo de Custo</th>
                            <th>Valor</th>
                            <th>Pagamento</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Cadastrado</th>
                            <th>Descrição</th>
                            <th>Tipo de Custo</th>
                            <th>Valor</th>
                            <th>Pagamento</th>
                            <th>Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr>
                                <td>{{$sel['id']}}</td>
                                <td>
                                    <span class="badge badge-{{$sel['status_array']['color']}}">{{$sel['status_array']['text']}}</span>
                                </td>
                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                <td>{{$sel['description']}}</td>
                                <td>{{$sel['cost_type_text']}}</td>
                                <td>{{$sel['value_currency']}}</td>
                                <td>{{$sel['payment_form']}}</td>
                                <td>
                                    @include('layout.inc.buttons.edit')
{{--                                    @include('layout.inc.buttons.delete')--}}
                                </td>
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

    <!-- Jquery Maskmoney Plugin Js -->
    @include('layout.inc.maskmoney.js')

    <!-- Jquery InputMask Js -->
    @include('layout.inc.inputmask.js')


    <script>
        $_INPUT_PARTNER_TYPE_ = 'select#contract_partner_type';
        $_INPUT_PARTNER_ = 'select#partner_id';

        var _CONTRACT_PARNER_TYPE_ = "{{old('contract_partner_type', Request::get('contract_partner_type'))}}"
        var _PARNER_ID_ = "{{old('partner_id', Request::get('partner_id'))}}"
        $(document).ready(function(){
            // $($_INPUT_STATE_).selectpicker();
            // $($_INPUT_CITY_).selectpicker();
            $($_INPUT_PARTNER_TYPE_).change(function(){
                var $this = $_INPUT_PARTNER_TYPE_;
                $($_INPUT_PARTNER_).empty();
                $($_INPUT_PARTNER_).append("<option value=''>Escolha o Parceiro</option>");
                // $($_INPUT_CITY_).val('').selectpicker('render');
                if($($_INPUT_PARTNER_TYPE_).val() == ""){
                    return false;
                }
//            console.log($(this).val());


                $.ajax({
                    url: '{{route('ajax.get.partners')}}',
                    data: {type : $($_INPUT_PARTNER_TYPE_).val()},
                    type: 'GET',
                    dataType: "json",
                    beforeSend: function (xhr, textStatus) {
                        loadingCard('show',$_INPUT_PARTNER_TYPE_);
                    },
                    error: function (xhr, textStatus) {
                        console.log('xhr-error: ' + xhr.responseText);
                        console.log('textStatus-error: ' + textStatus);
                    },
                    success: function (json) {
                        // console.log(json);
                        $(json).each(function(i,v){
                            $($_INPUT_PARTNER_).append('<option value="' + v.id + '">' + v.text + '</option>')
                        });

                        if(_PARNER_ID_ != ''){
                            $($_INPUT_PARTNER_).val(_PARNER_ID_).change();
                        }
                        loadingCard('hide',$_INPUT_PARTNER_TYPE_);
                    }
                });
            })

            // $($_INPUT_PARTNER_TYPE_).

            if(_CONTRACT_PARNER_TYPE_ != ''){
                $($_INPUT_PARTNER_TYPE_).val(_CONTRACT_PARNER_TYPE_).change();
            }
        })
    </script>
@endsection
