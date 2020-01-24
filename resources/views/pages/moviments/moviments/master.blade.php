@extends('layout.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_header-nav')

    @include('layout.inc.breadcrumb')

@endsection

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

                        <li class="nav-invoices">
                            <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices" role="tab" aria-controls="invoices" aria-selected="true">Notas @if($Data->invoices->count() > 0)<span class="badge badge-pill badge-info">{{$Data->invoices->count()}}</span> @endif</a>
                        </li>

                    @endif
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="informations" role="tabpanel" aria-labelledby="informations-tab">

                        @if(isset($Data))
                            {{Form::model($Data,
                                array(
                                    'route' => ['moviments.update', $Data->id],
                                    'method'=>'PATCH',
                                    'files'=>'true',
                                    'data-provide'=> "validation",
                                    'data-disable'=>'false'
                                )
                                )}}
                        @else
                            {{Form::open(array(
                                'route' => ['moviments.store'],
                                'method'=>'POST',
                                'files'=>'true',
                                'data-provide'=> "validation",
                                'data-disable'=>'false'
                            )
                            )}}
                        @endif
                        @include('pages.moviments.moviments.form.data')
                        {{Form::close()}}
                    </div>

                    @if(isset($Data))

                        <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                            <div class="card">
                                <h4 class="card-title"><strong>{{count($Data->invoices)}}</strong> Notas</h4>

                                <div class="card-content">
                                    <div class="card-body">

                                        <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Cadastro</th>
                                                <th>Série</th>
                                                <th>Número</th>
                                                {{--                                            <th>Ações</th>--}}
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Cadastro</th>
                                                <th>Série</th>
                                                <th>Número</th>
                                                {{--                                            <th>Ações</th>--}}
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($Data->invoices as $sel)
                                                <tr>
                                                    <td>{{$sel['id']}}</td>
                                                    <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at_formatted']}}</td>
                                                    <td>{{$sel['serie']}}</td>
                                                    <td>{{$sel['number']}}</td>
                                                    {{--                                                <td>--}}
                                                    {{--                                                    @include('layout.inc.buttons.edit')--}}
                                                    {{--                                    @include('layout.inc.buttons.delete')--}}
                                                    {{--                                                </td>--}}
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @include('layout.inc.loading')
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div><!--/.main-content -->
@endsection


@section('script_content')

    <!-- Jquery Validation Plugin Js -->
    @include('layout.inc.validation.js')


    <!-- Jquery Maskmoney Plugin Js -->
    @include('layout.inc.maskmoney.js')

    <!-- Jquery InputMask Js -->
    @include('layout.inc.inputmask.js')

    <script>

        $(document).ready(function () {
            var entity = {
                width: 'resolve',
                ajax: {
                    url: "{{route('ajax.get.entities')}}",
                    dataType: 'json',
                    delay: 250,

                    data: function (params) {
                        return {
                            value   : params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                language: "pt-BR"
            };
            var receiver = {
                width: 'resolve',
                ajax: {
                    url: "{{route('ajax.get.receivers')}}",
                    dataType: 'json',
                    delay: 250,

                    data: function (params) {
                        return {
                            value   : params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                language: "pt-BR"
            };
            $("select[name=sender_id]").select2(entity);
            $("select[name=dispatcher_id]").select2(entity);
            $("select[name=payer_id]").select2(entity);
            $("select[name=receiver_id]").select2(receiver);

        });

    </script>
@endsection
