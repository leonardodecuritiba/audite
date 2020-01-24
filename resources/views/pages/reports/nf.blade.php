@extends('pages.reports.template')

@section('filter_content')

    {!! Form::open(['route' => 'reports.nf',
                        'method' => 'GET']) !!}
    <div class="form-row">

        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('nf', 'Nota Fiscal', array('class' => 'col-form-label'))) !!}
            {{Form::text('nf', old('nf', Request::get('nf')), ['placeholder'=>'Nota Fiscal','class'=>'form-control',  'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="text-right">
        <button class="btn btn-primary" name="search" type="submit"><i class="ti-search"></i> Filtrar</button>
    </div>
    {{ Form::close() }}

@endsection