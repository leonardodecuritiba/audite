

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Form row
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->


<div class="card-body card-content">

    <div class="form-row">

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('cost_type', 'Tipo de Custo', array('class' => 'col-form-label'))) !!}
            {{Form::select('cost_type', $Page->auxiliar['cost_types'], old('cost_type',(isset($Data) ? $Data->cost_type : "")), ['placeholder' => 'Escolha o Tipo de Custo', 'class'=>'form-control ', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('value', 'Valor', array('class' => 'col-form-label'))) !!}
            {{Form::text('value', old('value',(isset($Data) ? $Data->value_formatted : "")), ['placeholder'=>'Valor','class'=>'form-control show-price', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            {!! Html::decode(Form::label('contract_partner_type', 'Tipo de Contrato', array('class' => 'col-form-label'))) !!}
            {{Form::select('contract_partner_type', $Page->auxiliar['contract_partner_types'], old('contract_partner_type',(isset($Data) ? $Data->contract_type : "")), ['placeholder' => 'Escolha o Tipo de Contrato', 'class'=>'form-control ', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-8">
            {!! Html::decode(Form::label('partner_id', 'Parceiro', array('class' => 'col-form-label'))) !!}
            {{Form::select('partner_id', [], old('partner_id',(isset($Data) ? $Data->partner_id : "")), ['placeholder' => 'Escolha o Parceiro', 'class'=>'form-control ', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            {!! Html::decode(Form::label('description', 'Descrição', array('class' => 'col-form-label'))) !!}
            {{Form::text('description', old('description',(isset($Data) ? $Data->description : "")), ['placeholder'=>'Descrição','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('contracted_at', 'Data de Contratação', array('class' => 'col-form-label'))) !!}
            {{Form::text('contracted_at', old('contracted_at',(isset($Data) ? $Data->contracted_at_formatted : "")), ['placeholder'=>'Data de Contratação','class'=>'form-control show-date', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('realized_at', 'Data de Realização', array('class' => 'col-form-label'))) !!}
            {{Form::text('realized_at', old('realized_at',(isset($Data) ? $Data->realized_at_formatted : "")), ['placeholder'=>'Data de Realização','class'=>'form-control show-date', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-9">
            {!! Html::decode(Form::label('payment_form', 'Forma de Pagamento', array('class' => 'col-form-label'))) !!}
            {{Form::text('payment_form', old('payment_form',(isset($Data) ? $Data->payment_form : "")), ['placeholder'=>'Forma de Pagamento','class'=>'form-control','minlength'=>'3', 'maxlength'=>'100', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group col-md-3">
            {!! Html::decode(Form::label('payment_date', 'Data de Pagamento', array('class' => 'col-form-label'))) !!}
            {{Form::text('payment_date', old('payment_date',(isset($Data) ? $Data->payment_date_formatted : "")), ['placeholder'=>'Data de Pagamento','class'=>'form-control show-date', 'required'])}}
            <div class="invalid-feedback"></div>
        </div>

    </div>

</div>
@include('layout.inc.loading')

@if(!isset($Data) || isset($Data) && $Data->canShowEditBtn())
    <footer class="card-footer text-right">
        <button class="btn btn-primary" type="submit">Salvar</button>
    </footer>
@endif

