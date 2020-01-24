@extends('pages.reports.template')

@section('filter_content')

    {!! Form::open(['route' => 'reports.cte',
                        'method' => 'GET']) !!}
    <div class="form-row">

        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('cte_number', 'Número do CTe', array('class' => 'col-form-label'))) !!}
            {{Form::text('cte_number', old('cte_number', Request::get('cte_number')), ['placeholder'=>'Número do CTe','class'=>'form-control',  'maxlength'=>'100'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="text-right">
        <button class="btn btn-primary" name="search" type="submit"><i class="ti-search"></i> Filtrar</button>
    </div>
    {{ Form::close() }}

@endsection