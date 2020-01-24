
{{Form::open(array(
    'route' => ['ajax.get.moviments', $Data->id],
    'method'=>'GET',
    'data-provide'=> "validation",
    'data-disable'=>'false'
)
)}}
<div class="form-row">

    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('begin_date', 'Data de Início', array('class' => 'col-form-label'))) !!}
        {{Form::text('begin_date', '', ['placeholder'=>'Data de Início','class'=>'form-control show-date'])}}
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('end_date', 'Data de Fim', array('class' => 'col-form-label'))) !!}
        {{Form::text('end_date', '', ['placeholder'=>'Data de Fim','class'=>'form-control show-date'])}}
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('state_id', 'Estado', array('class' => 'col-form-label'))) !!}
        {{Form::select('state_id', $Page->auxiliar['states'], old('state_id',''), ['placeholder' => 'Escolha o Estado', 'class'=>'form-control show-tick','id' => 'select-state'])}}
    </div>
    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('city_id', 'Cidade', array('class' => 'col-form-label'))) !!}
        {{Form::select('city_id', [], '', ['placeholder' => 'Escolha a Cidade', 'class'=>'form-control show-tick','id' => 'select-city'])}}
    </div>

</div>
<div class="form-row">

    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('cte_number', 'Número CT-e', array('class' => 'col-form-label'))) !!}
        {{Form::text('cte_number', old('cte_number', ""), ['placeholder'=>'Número CT-e','class'=>'form-control', 'maxlength'=>'20'])}}
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('first_manifest', 'Primeiro Manifesto', array('class' => 'col-form-label'))) !!}
        {{Form::text('first_manifest', old('first_manifest', ""), ['placeholder'=>'Primeiro Manifesto','class'=>'form-control', 'maxlength'=>20])}}
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('last_manifest', 'Último Manifesto', array('class' => 'col-form-label'))) !!}
        {{Form::text('last_manifest', old('last_manifest', ""), ['placeholder'=>'Último Manifesto','class'=>'form-control', 'maxlength'=>'20'])}}
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group col-md-3">
        {!! Html::decode(Form::label('last_cargo', 'Último Romaneio', array('class' => 'col-form-label'))) !!}
        {{Form::text('last_cargo', old('last_cargo', ""), ['placeholder'=>'Último Romaneio','class'=>'form-control', 'maxlength'=>'20'])}}
        <div class="invalid-feedback"></div>
    </div>


</div>
<footer class="card-footer text-right">
    <button class="btn btn-info" id="filter" type="button">Filtrar</button>
</footer>
{{Form::close()}}

<hr class="hr-sm mb-5">


<div id="shared-lists" class="row">
    <div class="col-md-4">
        <h5>Listagem</h5>
        <div id="list-original" class="list-original lists">
        </div>
    </div>
    <div class="col-md-8">
        <h5>Itens atuais</h5>
        <div id="list-nova" class="list-nova lists">
        </div>
    </div>
</div>

{{Form::open(array(
    'route' => ['contract_items.add', $Data->id],
    'id'=>'form-add-items',
    'method'=>'POST',
    'data-provide'=> "validation",
    'data-disable'=>'false'
)
)}}
{{Form::hidden('moviments','')}}
<footer class="card-footer text-right">
    <button class="btn btn-primary" type="submit">Salvar</button>
</footer>
{{Form::close()}}