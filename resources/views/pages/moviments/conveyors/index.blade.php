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
                            <th>Cadastrado</th>
                            <th>Iniciais</th>
                            <th>CPF/CNPJ</th>
                            <th>Razão Social</th>
                            {{--<th>Tabela</th>--}}
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Cadastrado</th>
                            <th>Iniciais</th>
                            <th>CPF/CNPJ</th>
                            <th>Razão Social</th>
                            {{--<th>Tabela</th>--}}
                            <th>Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr class="{{(!$sel['active']['value']) ? 'bg-pale-danger':''}}">
                                <td>{{$sel['id']}}</td>
                                <td data-order="{{$sel['created_at_time']}}">{{$sel['created_at']}}</td>
                                <td>{{$sel['initials']}}</td>
                                <td>{{$sel['document_formatted']}}</td>
                                <td>{{$sel['social_reason']}}</td>
                                {{--<td>{{$sel['price_type_formatted']}}</td>--}}
                                <td>
                                    @include('layout.inc.buttons.active',['active'=>$sel['active']])
                                    @include('layout.inc.buttons.edit')
                                    @include('layout.inc.buttons.delete')
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
    @include('layout.inc.active.js')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layout.inc.datatable.js')

    @include('layout.inc.sweetalert.js')

@endsection
