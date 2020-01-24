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
            <h4 class="card-title"><strong>Importação do {{$Page->name}}</strong></h4>
            <div class="card-body">
                {{Form::open(array(
                    'route' => ['invoices.import'],
                    'method'=>'POST',
                    'files'=>'true',
                    'data-provide'=> "validation",
                    'data-disable'=>'false'
                )
                )}}
                    <div class="card-body">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('partner_id', 'Transportadora', array('class' => 'col-form-label'))) !!}
                                {{Form::select('partner_id', $Page->auxiliar['partners'], old('partner_id', []), ['placeholder' => '', 'class'=>'form-control', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                {!! Html::decode(Form::label('file_import', 'Arquivo XLS', array('class' => 'control-label'))) !!}
                                {{Form::file('file_import', ['class'=>'form-control','id' => 'file_import', 'required'])}}
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <footer class="card-footer text-right">
                        <button class="btn btn-primary" type="submit">Enviar</button>
                    </footer>
                {{Form::close()}}
            </div>
        </div>
    </div><!--/.main-content -->
@endsection


@section('script_content')

@endsection
