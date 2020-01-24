@extends('layout.app')

@section('title', $Page->title)

@section('style_content')
    <!-- Bootstrap Select Css -->
    {{Html::style('bower_components/bootstrap-select/dist/css/bootstrap-select.css')}}
    <style>
        .tinted {
            background-color: #fff6b2;
        }
        .lists {
            border-style: dashed;
            border-width: 2px;
            min-height: 100px;
        }
        .list-original {
            border-color: #50d1ff;
        }
        .list-nova {
            border-color: #1700ff;
        }

        .list-group-item {
            border: 1px solid #f3f3f3 !important;
        }
    </style>
@endsection

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layout.inc.breadcrumb')

@endsection

@if(isset($Data))

    @section('page_modals')

        {{--VISUALIZAR ANTES DE ADICIONAR VOID--}}
        <div class="modal fade show " id="modal-items">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Itens</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        {{Form::open(array(
                            'route' => ['contract_items.save', $Data->id],
                            'method'=>'POST',
                            'data-disable'=>'false'
                        )
                        )}}
                        {{Form::hidden('contract_item_id',NULL)}}


                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Html::decode(Form::label('moviment_id', 'Movimento *', array('class' => 'col-form-label'))) !!}
                                    {{Form::select('moviment_id', $Page->auxiliar['moviments'], "", ['placeholder' => 'Escolha o Movimento', 'class'=>'form-control', 'required'])}}
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal"> Cancelar</button>
                            <button class="btn btn-label btn-primary"><label><i class="ti-check"></i></label> Salvar
                            </button>
                        </div>


                        {{Form::close()}}
                    </div>

                </div>
            </div>
        </div>

    @endsection

@endif

@section('page_content')
    <!-- Main container -->
    <div class="main-content">


    @include('layout.inc.alerts')

    <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        <div class="card">
            @if(isset($Data))
                <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getShortName()}}</strong>
                    @if($Data->canShowCloseBtn())
                        <a class="btn btn-a btn-primary mr-10 pull-right" href="{{route('contracts.close', $Data->id)}}">Fechar</a>
                    @endif
                    @if($Data->canShowCancelBtn())
                        <a class="btn btn-a btn-danger mr-10 pull-right" href="{{route('contracts.cancel', $Data->id)}}">Cancelar</a>
                    @endif
                </h4>
            @else
                <h4 class="card-title"><strong>Dados do {{$Page->name}}</strong></h4>
            @endif
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="informations-tab" data-toggle="tab" href="#informations" role="tab" aria-controls="informations" aria-selected="true">Informações</a>
                    </li>

                    @if(isset($Data))
                        <li class="nav-item">
                            <a class="nav-link" id="items-tab" data-toggle="tab" href="#items" role="tab" aria-controls="items" aria-selected="true">Itens @if($Data->items->count() > 0)<span class="badge badge-pill badge-info">{{$Data->items->count()}}</span> @endif</a>
                        </li>

                        @if($Data->canShowAddItemBtn())
                            <li class="nav-item">
                                <a class="nav-link" id="add-items-tab" data-toggle="tab" href="#add-items" role="tab" aria-controls="items" aria-selected="true">Adicionar Itens</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a class="nav-link" id="logs-tab" data-toggle="tab" href="#logs" role="tab" aria-controls="logs" aria-selected="true">Logs</a>
                        </li>
                    @endif
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="informations" role="tabpanel" aria-labelledby="informations-tab">

                        @if(isset($Data))

                            @include('layout.inc.status',['status'=>$Data->status_array])

                            {{Form::model($Data,
                                array(
                                    'route' => ['contracts.update', $Data->id],
                                    'method'=>'PATCH',
                                    'files'=>'true',
                                    'data-provide'=> "validation",
                                    'data-disable'=>'false'
                                )
                                )}}
                        @else
                            {{Form::open(array(
                                'route' => ['contracts.store'],
                                'method'=>'POST',
                                'files'=>'true',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                            )
                            )}}
                        @endif
                        @include('pages.moviments.contracts.form.data')
                    {{Form::close()}}
                    </div>

                    @if(isset($Data))

                        <div class="tab-pane fade" id="items" role="tabpanel" aria-labelledby="items-tab">
                            <div class="card">
                                <div class="form-row">
                                    @if($Data->canShowAddItemBtn())
                                        <button class="btn btn-info pull-right"
                                                type="button"
                                                data-toggle="modal" data-target="#modal-items" data-type="new">Adicionar
                                        </button>
                                    @endif
                                </div>
                                <div class="card-content">
                                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Remetente</th>
                                            <th>Número CTe</th>
                                            <th>Notas Fiscais</th>
                                            <th>Peso Calculado (Kg)</th>
                                            <th>Primeiro Manifesto</th>
                                            <th>Último Manifesto</th>
                                            <th>Município</th>
                                            <th>UF</th>
                                            @if($Data->isClosed())
                                                <th>Valor Ponderado</th>
                                                <th>Valor Distribuído</th>
                                            @endif
                                            @if($Data->canShowDeleteItemBtn())
                                                <th>Ações</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Remetente</th>
                                            <th>Número CTe</th>
                                            <th>Notas Fiscais</th>
                                            <th>Peso Calculado (Kg)</th>
                                            <th>Primeiro Manifesto</th>
                                            <th>Último Manifesto</th>
                                            <th>Município</th>
                                            <th>UF</th>
                                            @if($Data->isClosed())
                                                <th>Valor Ponderado</th>
                                                <th>Valor Distribuído</th>
                                            @endif
                                            @if($Data->canShowDeleteItemBtn())
                                                <th>Ações</th>
                                            @endif
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach($Data->items as $sel)
                                            <tr>
                                                <td><a target="_blank" href="{{route('moviments.edit',$sel->moviment->id)}}">{{$sel->moviment->id}}</a></td>
                                                <td>{{$sel->moviment->sender->short_description}}</td>
                                                <td>{{$sel->moviment->cte_number}}</td>
                                                <td>{{$sel->moviment->getInvoicesText()}}</td>
                                                <td>{{$sel->moviment->weight_calculated_formatted}}</td>
                                                <td>{{$sel->moviment->first_manifest}}</td>
                                                <td>{{$sel->moviment->last_manifest}}</td>
                                                <td>{{$sel->moviment->receiver->address->city_name}}</td>
                                                <td>{{$sel->moviment->receiver->address->uf_name}}</td>
                                                @if($Data->isClosed())
                                                    <td>{{$sel->pondered_value_formatted}}</td>
                                                    <td>{{$sel->distributed_value_formatted}}</td>
                                                @endif
                                                @if($Data->canShowDeleteItemBtn())
                                                    <td>
                                                        @include('layout.inc.buttons.delete',['field_delete' => "Movimento",'field_delete_route'=>route('contract_items.delete', $sel->id)])
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @include('layout.inc.loading')
                            </div>
                        </div>


                        @if($Data->canShowAddItemBtn())
                            <div class="tab-pane fade" id="add-items" role="tabpanel" aria-labelledby="add-items-tab">
                                <div class="card">
                                    <div class="card-body card-content">
                                        @include('pages.moviments.moviments.form.filter-item')
                                    </div>
                                    @include('layout.inc.loading')
                                </div>
                            </div>
                        @endif

                        <div class="tab-pane fade" id="logs" role="tabpanel" aria-labelledby="logs-tab">
                            <div class="card">
                                <ol class="timeline timeline-activity timeline-point-sm timeline-content-right w-100 py-20 pr-20">
                                    @foreach($Data->logs as $log)
{{--                                        {{$log}}--}}
                                        <li class="timeline-block">
                                            <div class="timeline-point">
                                                <span class="badge badge-dot badge-lg badge-{{$log->log_color}}"></span>
                                            </div>
                                            <div class="timeline-content">
                                                <time datetime="2018">{{$log->created_at_human_formatted}}</time>
                                                <p><b>{{$log->getCreatorName()}}</b>: {{$log->log_text}}</p>
                                            </div>
                                        </li>
                                    @endforeach

                                </ol>
                            </div>
                        </div>
                    @endif
                </div>


            </div>            
        </div>
    </div><!--/.main-content -->
@endsection


@section('script_content')

    @include('layout.inc.datatable.js')

    @include('layout.inc.sweetalert.js')

    <!-- Bootstrap Select Js -->
    {{Html::script('bower_components/bootstrap-select/dist/js/bootstrap-select.min.js')}}


    <!-- Jquery Validation Plugin Js -->
    @include('layout.inc.validation.js')


    <!-- Jquery Maskmoney Plugin Js -->
    @include('layout.inc.maskmoney.js')

    <!-- Jquery InputMask Js -->
    @include('layout.inc.inputmask.js')

    <script>
        $_INPUT_PARTNER_TYPE_ = 'select#contract_partner_type';
        $_INPUT_PARTNER_ = 'select#partner_id';
        var _CONTRACT_PARNER_TYPE_ = "{{isset($Data) ? $Data->contract_partner_type : ''}}"
        var _PARNER_ID_ = "{{isset($Data) ? $Data->partner_id : ''}}"
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

    <!-- jquery-sortable Js -->
    {{Html::script('bower_components/Sortable/Sortable.min.js')}}

    <script>
        var IDS = [];
        $(document).ready(function(){
            var example2Left = document.getElementById('list-original'),
                example2Right = document.getElementById('list-nova');

            new Sortable(example2Left, {
                group: {
                    name: 'shared',
                    // pull: 'clone',
                    put: false // Do not allow items to be put into this list
                },
                animation: 150,
                sort: false,
                onEnd: function (evt) {
                    var itemEl = evt.item;  // dragged HTMLElement
                    var id = $(itemEl).data('id');
                    var add = true;
                    $.each(IDS, function( index, value ) {
                        if(id == value){
                            swal(
                                "",
                                "<b>Erro!</b> Este item já foi adicionado.",
                                "error"
                            )
                            add = false;
                        }

                    });
                    if(add){
                        IDS.push(id);
                    } else {
                        $(itemEl).remove();
                    }
                    // return -1; — insert before target
                    // return 1; — insert after target
                },

            });

            new Sortable(example2Right, {
                group: 'shared',
                animation: 150,
            });
        });

    </script>
    <script>
        $(document).ready(function(){
            $('button#filter').click(function(){
                var form = $(this).closest('form');
                $.ajax({
                    url: form.attr('action'),
                    data: form.serialize(),
                    type: 'GET',
                    dataType: "json",
                    beforeSend: function (xhr, textStatus) {
                        loadingCard('show',form);
                    },
                    error: function (xhr, textStatus) {
                        console.log('xhr-error: ' + xhr.responseText);
                        console.log('textStatus-error: ' + textStatus);
                        loadingCard('hide',form);
                    },
                    success: function (json) {
                        // console.log(json);
                        $('div#shared-lists').find('div#list-original').empty();
                        if(json != null){
                            $.each(json,function(i,v){
                                $('div#shared-lists').find('div#list-original').append(
                                    '<div class="list-group-item tinted" data-id="'+v.id+'">'+v.text+'</div>'
                                )
                            })
                        }
                        loadingCard('hide',form);

                        var height = $('div#shared-lists').find('div#list-original').height();
                        $('div#shared-lists').find('div#list-nova').height(height);
                    }
                });
            });


            $('form#form-add-items').on('submit', function(){
                if(IDS.length == 0){
                    return false;
                }
                $(this).find('input[name=moviments]').val(JSON.stringify(IDS));
            })
        })
        var _STATE_ID_ = _CITY_ID_ = '';
    </script>

    <!-- Address Layout Js -->
    @include('layout.inc.address.js')
@endsection
