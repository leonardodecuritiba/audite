@extends('layout.app')

@section('title', $Page->title)

@section('style_content')

@endsection

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layout.inc.breadcrumb')

@endsection


@if(isset($Data))

@section('page_modals')

    {{--VISUALIZAR ANTES DE ADICIONAR VOID--}}
    <div class="modal fade show " id="modal-generalities">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">


                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Custos Generalidades</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    {{Form::open(array(
                        'route' => ['conveyor_generalities.save', $Data->id],
                        'method'=>'POST',
                        'data-disable'=>'false'
                    )
                    )}}
                    {{Form::hidden('conveyor_generality_id',NULL)}}
                    {{Form::hidden('conveyor_generality_type',NULL)}}


                    <div class="row">

                        <div class="col-md-12" id="div-type">
                            <div class="form-group">
                                {!! Html::decode(Form::label('type', 'Tipo *', array('class' => 'col-form-label'))) !!}
                                <select name="generality_type" class="form-control select2_single" required>
                                    @foreach($Page->auxiliar['generalities'] as $generality)
                                        <option value="{{$generality['id']}}" data-type="{{$generality['type']}}" data-min="{{$generality['min']}}">{{$generality['description']}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>


                        <div class="col-md-12" id="div-type-text">
                            <div class="form-group">
                                {!! Html::decode(Form::label('type_name', 'Tipo', array('class' => 'col-form-label'))) !!}
                                {{Form::text('type_name', '', ['placeholder'=>'Tipo','class'=>'form-control', 'disabled'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Html::decode(Form::label('value', 'Valor *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('value', '', ['placeholder'=>'Valor *','class'=>'form-control show-price hidex'])}}
                                {{Form::text('value_percent', '', ['placeholder'=>'Porcentagem *','class'=>'form-control show-percent3', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                    </div>

                    <div class="row hidex">

                        <div class="col-md-3">
                            {!! Html::decode(Form::label('has_min', 'Cobra Mínimo?', array('class' => 'col-form-label'))) !!}
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"  name="has_min">
                                <label class="custom-control-label" for="has_min">Sim</label>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="form-group">
                                {!! Html::decode(Form::label('value', 'Valor Mínimo *', array('class' => 'col-form-label'))) !!}
                                {{Form::text('value_min', '', ['placeholder'=>'Valor Mínimo *','class'=>'form-control show-price', 'disabled'])}}
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
                <h4 class="card-title"><strong>#{{$Data->id}} - {{$Data->getShortName()}}</strong></h4>
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
                            <a class="nav-link" id="price-tables-tab" data-toggle="tab" href="#price-tables" role="tab" aria-controls="price-tables" aria-selected="false">Tabelas Frete</a>
                        </li>
                        @if($Data->price_type != NULL)
                            <li class="nav-item">
                                <a class="nav-link" id="add-price-tables-tab" data-toggle="tab" href="#add-price-tables" role="tab" aria-controls="price-tables" aria-selected="false">Adicionar Tabelas Frete</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" id="generalities-tab" data-toggle="tab" href="#generalities" role="tab" aria-controls="generalities" aria-selected="false">Generalidades</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="informations" role="tabpanel" aria-labelledby="informations-tab">

                        @if(isset($Data))
                        {{Form::model($Data,
                            array(
                                'route' => ['conveyors.update', $Data->id],
                                'method'=>'PATCH',
                                'files'=>'true',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                            )
                            )}}
                        @else
                            {{Form::open(array(
                                'route' => ['conveyors.store'],
                                'method'=>'POST',
                                'files'=>'true',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                            )
                            )}}
                        @endif
                        @include('pages.moviments.conveyors.form.data')
                    {{Form::close()}}
                    </div>
                    @if(isset($Data))
                        <div class="tab-pane fade" id="price-tables" role="tabpanel" aria-labelledby="price-tables-tab">
                            <!-- Main container -->
                            <div class="card-body">

                                {{Form::model($Data,
                                    array(
                                        'route' => ['conveyors.update.price-table', $Data->id],
                                        'method'=>'PATCH',
                                        'data-provide'=> "validation",
                                        'data-disable'=>'false'
                                    )
                                    )}}

                                @if($Data->price_type == NULL)

                                    <hr class="hr-sm mb-2">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            {!! Html::decode(Form::label('price_type', 'Tipo *', array('class' => 'col-form-label'))) !!}
                                            {{Form::select('price_type', $Page->auxiliar['price_types'], "", ['placeholder' => 'Escolha o Tipo de Tabela Frete', 'class'=>'form-control', 'required'])}}
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-8">
                                            {!! Html::decode(Form::label('description', 'Descrição *', array('class' => 'col-form-label'))) !!}
                                            {{Form::text('description', old('description',(isset($Data) ? $Data->description : "")), ['placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            {!! Html::decode(Form::label('priority_type', 'Prioridade *', array('class' => 'col-form-label'))) !!}
                                            {{Form::select('priority_type', $Page->auxiliar['priority_types'], "", ['placeholder' => 'Escolha a Prioridade', 'class'=>'form-control', 'required'])}}
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                @else

                                    <div class="form-row">
                                        <label class="col-sm-2 col-form-label">Tipo</label>
                                        <div class="col-sm-10">
                                            <p class="form-control-plaintext">{{$Data->price_type_formatted}}
                                                <button onclick="deleteType()" type="button" class="btn btn-danger btn-xs">Remover</button></p>
                                        </div>
                                    </div>

                                    <hr class="hr-sm mb-2">

                                    <div class="form-row">
                                        <div class="form-group col-md-8">
                                            {!! Html::decode(Form::label('description', 'Descrição *', array('class' => 'col-form-label'))) !!}
                                            {{Form::text('description', old('description',(isset($Data) ? $Data->description : "")), ['placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            {!! Html::decode(Form::label('priority_type', 'Prioridade *', array('class' => 'col-form-label'))) !!}
                                            {{Form::select('priority_type', $Page->auxiliar['priority_types'], $Data->priority_type, ['placeholder' => 'Escolha a Prioridade', 'class'=>'form-control', 'required'])}}
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                @endif

                                <footer class=" text-right">
                                    <button class="btn btn-primary" type="submit">Salvar</button>
                                </footer>

                                {{Form::close()}}
                            </div>

                            @if($Data->price_type != NULL)
                                <hr class="hr-sm mb-2">

                                <h4 class="card-title"><strong>Localidades Atendidas</strong></h4>

                                @include('pages.moviments.conveyors.price_ranges.index.range', ['prices' => $Data->getPriceRange()])

                            @endif

                        </div>

                        @if($Data->price_type != NULL)
                            <div class="tab-pane fade" id="add-price-tables" role="tabpanel" aria-labelledby="add-price-tables-tab">

                                <div class="card">

                                    @if($Data->isType('A'))
                                        @include('pages.moviments.conveyors.price_ranges.form.range_a')
                                    @elseif($Data->isType('B'))
                                        @include('pages.moviments.conveyors.price_ranges.form.range_b')
                                    @elseif($Data->isType('C'))
                                        @include('pages.moviments.conveyors.price_ranges.form.range_c')
                                    @elseif($Data->isType('D'))
                                        @include('pages.moviments.conveyors.price_ranges.form.range_d')
                                    @elseif($Data->isType('E'))
                                        @include('pages.moviments.conveyors.price_ranges.form.range_e')
                                    @endif
                                        <div class="card-content">
                                            <div class="card-body">
                                                <table class="table table-striped table-bordered" id="cities_price" cellspacing="0" data-provide="datatablesdefault" data-scroll-y="250px" data-scroll-collapse="true" data-paging="false" role="grid">
                                                    <thead>
                                                    <tr>
                                                        <th width="50px">#</th>
                                                        <th>Cidade</th>
                                                    </tr>
                                                    </thead>
                                                </table>

                                            </div>
                                        </div>
                                        @include('layout.inc.loading')

                                        <footer class=" text-right">
                                            <button class="btn btn-primary" type="submit">Salvar</button>
                                        </footer>

                                    {{Form::close()}}
                                </div>
                            </div>
                        @endif

                        <div class="tab-pane fade" id="generalities" role="tabpanel" aria-labelledby="generalities-tab">

                            <div class="card">

                                <h4 class="card-title"><strong>Generalidades</strong>
                                    <button class="btn btn-info pull-right"
                                            type="button"
                                            data-toggle="modal" data-target="#modal-generalities" data-type="new">Adicionar
                                    </button>
                                </h4>

                                <div class="card-content">
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Descrição</th>
                                                <th>Valor</th>
                                                <th>Ação</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Descrição</th>
                                                <th>Valor</th>
                                                <th>Ação</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach($Data->generalities as $sel)
                                                    <tr>
                                                        <td width="50px">{{$sel->id}}</td>
                                                        <td>{{$sel->type_text}}</td>
                                                        <td data-order="{{$sel->value}}">{{$sel->value_formatted.$sel->value_min_formatted}}</td>
                                                        <td>
                                                            <button data-toggle="modal"
                                                                    data-sel="{{$sel}}"
                                                                    data-target="#modal-generalities"
                                                                    class="btn btn-square btn-xs btn-outline btn-success"><i class="fa fa-pencil"></i></button>

                                                            @include('layout.inc.buttons.delete',['field_delete' => "Generalidade",'field_delete_route'=>route('conveyor_generalities.delete', $sel->id)])
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

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

    <!-- Jquery Validation Plugin Js -->
    @include('layout.inc.validation.js')


    <!-- Jquery Maskmoney Plugin Js -->
    @include('layout.inc.maskmoney.js')

    <!-- Jquery InputMask Js -->
    @include('layout.inc.inputmask.js')

    <!-- Address Layout Js -->
    @include('layout.inc.address.js')

    <script>
        function toggleType($this, val) {

            var $parent = $($this).closest('div.form-row');
            var $div_pf = $($parent).find('div.section-pf');
            var $div_pj = $($parent).find('div.section-pj');

            if (val == "0") {
                // $('input[name="type"]#pf').prop('checked', true);
                $($div_pj).hide();
                $($div_pj).find('input').attr('required', false);
                $($div_pf).fadeIn('fast');
                $($div_pf).find('input').attr('required', true);
//                $('section.section-pj').find('input').val("");
            } else {
                $($div_pf).hide();
                $($div_pf).find('input').attr('required', false);
                $($div_pj).fadeIn('fast');
                $($div_pj).find('input').attr('required', true);
            }
        }

        $(document).ready(function () {
            $('input[name="type"]').change(function () {
                toggleType($(this), $(this).val());
            });

            toggleType($('input[name="type"]'), '{{isset($Data) ? $Data->type : 1}}');
        });

    </script>


    @if(isset($Data))
        <script>

            $_state_price_ = 'select[name=state_price]';
            $_cities_table_ = 'table#cities_price';

            $(document).ready(function(){
                $($_state_price_).click(function(){
                    var _TABLE_CITIES_ = $($_cities_table_).DataTable();

                    _TABLE_CITIES_
                        .clear()
                        .draw();
                    if($($_state_price_).val() == ""){
                        return false;
                    }

                    $.ajax({
                        url: '{{route('ajax.get.state-city')}}',
                        data: {id : $($_state_price_).val()},
                        type: 'GET',
                        dataType: "json",
                        beforeSend: function (xhr, textStatus) {
                            loadingCard('show', $_cities_table_);
                        },
                        error: function (xhr, textStatus) {
                            console.log('xhr-error: ' + xhr.responseText);
                            console.log('textStatus-error: ' + textStatus);
                            loadingCard('hide', $_cities_table_);
                        },
                        success: function (json) {
                            // console.log(json);
                            $(json).each(function(i,v){
                                _TABLE_CITIES_
                                    .row.add( [
                                    '<input type="checkbox" value="1" name="cities[' + v.id + ']">',
                                    v.name,
                                ] ).draw( false );
                            });
                            loadingCard('hide', $_cities_table_);
                        }
                    });
                })
            })
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                //MODAL DA FORMA DE PAGAMENTO
                $('#modal-generalities').on('show.bs.modal', function (event) {

                    var $button = $(event.relatedTarget);
                    var $parent = $(this).find('div.modal-body');
                    var $portion_type = $($parent).find('div#div-type');
                    var $portion_type_txt = $($parent).find('div#div-type-text');
                    $($portion_type_txt).find('input').val('');
                    $($parent).find('input[name=conveyor_generality_id]').val('');


                    if($button.attr('data-type') == 'new'){
                        $($portion_type).find('select[name=type]').attr('required', true);
                        $($portion_type).show();
                        $($portion_type_txt).hide();
                        $($parent).find('input[name=value]').maskMoney('mask', parseFloat(0));
                    } else {
                        $($portion_type).find('select[name=type]').attr('required', false);
                        $($portion_type).hide();
                        $($portion_type_txt).show();
                        var $g = $($button).data('sel');
                        $($portion_type_txt).find('input').val($g.type_text);
                        $($parent).find('input[name=value]').maskMoney('mask', parseFloat($g.value));
                        console.log($g);
                        $($parent).find('input[name=conveyor_generality_id]').val($g.id);
                    }
                });
            });

            $(document).ready(function () {
                $('select[name="generality_type"]').change(function () {
                    var type = $(this).find('option:selected').data('type');
                    var min = $(this).find('option:selected').data('min');
                    $parent = $(this).closest('div.row').next();
                    $form = $(this).closest('form');
                    $($form).find('input[name=conveyor_generality_type]').val(type);
                    $($form).find('input[name="has_min"]').prop('checked', false).change();

                    if(type == 'percent'){
                        $($parent).find('input[name=value]')
                            .attr('required',false).addClass('hidex');
                        $($parent).find('input[name=value]')
                            .maskMoney('mask', parseFloat(0));;
                        $($parent).find('input[name=value_percent]')
                            .attr('required',true).removeClass('hidex');
                    } else {
                        $($parent).find('input[name=value_percent]')
                            .attr('required',false).addClass('hidex');
                        $($parent).find('input[name=value_percent]')
                            .maskMoney('mask', parseFloat(0));
                        $($parent).find('input[name=value]')
                            .attr('required',true).removeClass('hidex');
                    }


                    if(min){
                        $($parent).next().removeClass('hidex');
                    } else {
                        $($parent).next().addClass('hidex');
                    }
                });

                $('select[name="generality_type"]').change();
                $('input[name="has_min"]').change(function () {
                    if($(this).prop( "checked") == true) {
                        $(this).closest('div.row')
                            .find('input[name=value_min]')
                            .attr('disabled', false)
                            .attr('required',true);
                    } else {
                        $(this).closest('div.row')
                            .find('input[name=value_min]')
                            .attr('disabled', true)
                            .attr('required',false);
                    }
                });

            });
        </script>


        <script type="text/javascript">
            function selectAllCities(){
                var _TABLE_CITIES_ = $($_cities_table_).DataTable();
                if(_TABLE_CITIES_.data().count() > 0){

                    $($_cities_table_).find('input').prop( "checked", true );
                }

            }
        </script>
        <script type="text/javascript">

            function deleteType() {
                swal({
                    title: "Você tem certeza?",
                    text: "Esta ação será irreversível!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    //            confirmButtonText: "<i class='em em-triumph'></i> Sim! ",
                    //            cancelButtonText: "<i class='em em-cold_sweat'></i> Não, cancele por favor! ",
                    confirmButtonText: "Sim! ",
                    cancelButtonText: "Não, cancelar! "
                }).then(
                    function (isConfirm) {
                        if (typeof isConfirm.dismiss == 'undefined') {
                            window.location.href="{{route('conveyors.destroy-type', $Data->id)}}";
                        } else {
                            swal(
                                "Cancelado",
                                "Nenhuma alteração realizada!",
                                //                    "<i class='em em-heart_eyes'></i>",
                                //                    "Ufa, <b>" + entity + "</b> está a salvo :)",
                                "error"
                            )
                        }
                    }
                );

            }

        </script>


    @endif
@endsection
