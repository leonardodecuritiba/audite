@extends('pages.reports.template')

@section('filter_content')

    {!! Form::open(['route' => 'reports.cost',
                        'method' => 'GET']) !!}
    <div class="form-row">

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('payer_id', 'Cliente Pagador', array('class' => 'col-form-label'))) !!}
            {{Form::select('payer_id', $Page->auxiliar['payers'], old('status', Request::get('payer_id')), ['placeholder' => 'Todos', 'class'=>'form-control select2_single'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('cost_type', 'Tipo de Custo', array('class' => 'col-form-label'))) !!}
            {{Form::select('cost_type', $Page->auxiliar['cost_types'], old('cost_type', Request::get('cost_type')), ['placeholder' => 'Todos', 'class'=>'form-control select2_single'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('contract_partner_type', 'Tipo de Contrato', array('class' => 'col-form-label'))) !!}
            {{Form::select('contract_partner_type', $Page->auxiliar['contract_partner_types'], '', ['placeholder' => 'Todos', 'class'=>'form-control select2_single'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('partner_id', 'Parceiro', array('class' => 'col-form-label'))) !!}
            {{Form::select('partner_id', [], '', ['placeholder' => 'Escolha o Parceiro', 'class'=>'form-control select2_single'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('start_at', 'Data Inicial', array('class' => 'col-form-label'))) !!}
            {{Form::text('start_at', old('start_at', Request::get('start_at')), ['placeholder'=>'Data Inicial','class'=>'form-control show-date'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('end_at', 'Data Final', array('class' => 'col-form-label'))) !!}
            {{Form::text('end_at', old('end_at', Request::get('end_at')), ['placeholder'=>'Data Final','class'=>'form-control show-date'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="text-right">
        <button class="btn btn-primary" name="search" type="submit"><i class="ti-search"></i> Filtrar</button>
    </div>
    {{ Form::close() }}


@endsection