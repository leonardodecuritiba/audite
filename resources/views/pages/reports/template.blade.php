@extends('layout.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)


@section('style_content')

    <!-- Jquery Select2 Js -->
    @include('layout.inc.select2.css')
@endsection

@section('page_modals')

    <div class="modal fade show " id="show-items" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePassword">Itens</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Tipo de Custo</th>
                            <th>Tipo de Contrato</th>
                            <th>Parceiro</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Tipo de Custo</th>
                            <th>Tipo de Contrato</th>
                            <th>Parceiro</th>
                        </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>#</td>
                                <td>#</td>
                                <td>#</td>
                                <td>#</td>
                                <td>#</td>
                                <td>#</td>
                            </tr>

                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

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

                    @yield('filter_content')

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
                            <th>Número</th>
                            <th>Receita</th>
                            <th>Despesa</th>
                            <th>Resultado</th>
                            <th>Percentual</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Número</th>
                            <th>Receita</th>
                            <th>Despesa</th>
                            <th>Resultado</th>
                            <th>Percentual</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr>
                                <td><a href="{{route('moviments.edit', $sel['moviment_id'])}}">{{$sel['moviment_id']}}</a></td>
                                <td>{{$sel['text']}}</td>
                                <td data-order="{{$sel['income']}}" class="text-info fw-500 w-90px">{{$sel['income_formatted']}}</td>
                                <td data-order="{{$sel['cost']}}" class="text-brown fw-500 w-90px">{{$sel['cost_formatted']}}
                                    <a href="#"
                                       class="ml-1 btn btn-square btn-outline btn-xs btn-info"
                                        data-toggle="modal"
                                       data-target="#show-items"
                                       data-items="{{$sel['items']}}"
                                    ><i class="ti ti-new-window"></i>
                                    </a>
                                </td>
                                <td data-order="{{$sel['result']}}" class="@if($sel['result']>0) text-success @else text-danger @endif fw-500 w-90px">{{$sel['result_formatted']}}</td>
                                <td data-order="{{$sel['percent']}}" class="@if($sel['result']<0) text-danger @endif fw-500 w-90px">{{$sel['percent_formatted']}}</td>
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

    <!-- Jquery Select2 Js -->
    @include('layout.inc.select2.js')

    <!-- Jquery InputMask Js -->
    @include('layout.inc.inputmask.js')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layout.inc.datatable.js')

    <script>
        $_INPUT_PARTNER_TYPE_ = 'select#contract_partner_type';
        $_INPUT_PARTNER_ = 'select#partner_id';
        var _CONTRACT_PARNER_TYPE_ = "{{Request::get('contract_partner_type')}}"
        var _PARNER_ID_ = "{{Request::get('partner_id')}}"
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

    <script>
        $('#show-items').on('show.bs.modal', function (event) {

            var $button = $(event.relatedTarget);
            var $parent = $(this).find('div.modal-body');
            var items = $($button).data('items');
            var t = $($parent).find('table').DataTable();
            t.clear();
            counter = 0;
            $(items).each(function(i,v){

                t.row.add( [
                    v.id,
                    v.created_at,
                    v.value_formatted,
                    v.cost_type_text,
                    v.contract_partner_type_text,
                    v.partner_text,

                ] ).draw( false );
            });
            console.log(items);
        });
    </script>

@endsection
