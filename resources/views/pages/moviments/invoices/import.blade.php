@extends('layout.app')

@section('title', $Page->title)

@section('style_content')

@endsection

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
            <h4 class="card-title"><strong>{{count($Page->response)}}</strong> {{$Page->names}}</h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>DATA</th>
                            <th>TIPO SERVIÇO</th>
                            <th>REMETENTE</th>
                            <th>CNPJ REMETENTE</th>
                            <th>CIDADE REMETENTE</th>
                            <th>UF REMETENTE</th>
                            <th>DESTINATARIO</th>
                            <th>CNPJ DESTINATARIO</th>
                            <th>CIDADE DESTINATARIO</th>
                            <th>UF DESTINATARIO</th>
                            <th>N. CTE / N. COLETA</th>
                            <th>NOTAS FISCAIS</th>
                            <th>VALOR NF.</th>
                            <th>PESO CALCULADO</th>
                            <th>PESO EXC. KG</th>
                            <th>VOL</th>
                            <th>VALOR DO FRETE</th>
                            <th>INFORMAÇÕES COMPLEMENTARES</th>
                            <th>FALHAS</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>DATA</th>
                            <th>TIPO SERVIÇO</th>
                            <th>REMETENTE</th>
                            <th>CNPJ REMETENTE</th>
                            <th>CIDADE REMETENTE</th>
                            <th>UF REMETENTE</th>
                            <th>DESTINATARIO</th>
                            <th>CNPJ DESTINATARIO</th>
                            <th>CIDADE DESTINATARIO</th>
                            <th>UF DESTINATARIO</th>
                            <th>N. CTE / N. COLETA</th>
                            <th>NOTAS FISCAIS</th>
                            <th>VALOR NF.</th>
                            <th>PESO CALCULADO</th>
                            <th>PESO EXC. KG</th>
                            <th>VOL</th>
                            <th>VALOR DO FRETE</th>
                            <th>INFORMAÇÕES COMPLEMENTARES</th>
                            <th>FALHAS</th>
                        </tr>
                        </tfoot>
                        <tbody>
                            @foreach($Page->response as $sel)
                                <tr>
{{--                                <tr class="{{(count($sel['errors']) > 0) ? 'bg-pale-danger':''}}">--}}
                                    <td>{{$sel['data']}}</td>
                                    <td>{{$sel['tipo_servico']}}</td>
                                    <td>{{$sel['remetente']}}</td>
                                    <td>{{$sel['cnpj_remetente']}}</td>
                                    <td>{{$sel['cidade_remetente']}}</td>
                                    <td>{{$sel['uf_remetente']}}</td>
                                    <td>{{$sel['destinatario']}}</td>
                                    <td>{{$sel['cnpj_destinatario']}}</td>
                                    <td>{{$sel['cidade_destinatario']}}</td>
                                    <td>{{$sel['uf_destinatario']}}</td>
                                    <td>{{$sel['n._cte_n._coleta']}}</td>
                                    <td>{{$sel['notas_fiscais']}}</td>
                                    <td>{{$sel['valor_nf']}}</td>
                                    <td>{{$sel['peso_calculado']}}</td>
                                    <td>{{$sel['peso_exc._kg']}}</td>
                                    <td>{{$sel['vol']}}</td>
                                    <td>{{$sel['valor_do_frete']}}</td>
                                    <td>{{$sel['informacoes_complementares']}}</td>
                                    <td><ul>@foreach($sel['errors'] as $err) <li>{{$err}}</li> @endforeach</ul></td>
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

@endsection
